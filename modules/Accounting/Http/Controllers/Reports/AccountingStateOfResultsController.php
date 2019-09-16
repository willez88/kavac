<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use Auth;

/**
 * @class AccountingReportPdfStateOfResultsController
 * @brief Controlador para la generación del reporte de estado de resultados
 *
 * Clase que gestiona el reporte de estado de resultados
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingStateOfResultsController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.stateofresults', ['only' => ['pdf']]);
    }

    /**
     * vista en la que se genera el reporte en pdf de balance general
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     */

    public function pdf($date, $level, $zero = false)
    {
        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'stateOfResults/pdf/'.$date.'/'.$level.'/'.$zero;
        AccountingReportHistory::updateOrCreate(
            [
                                                    'report' => 'Estado de Resultados',
                                                ],
            [
                                                    'url' => $url,
                                                ]
        );
        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /** @var Object String en el que se formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss) */
        $endDate = $date.'-'.$day;

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_1 = 'seatAccount.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_2 = 'children.seatAccount.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_3 = 'children.children.seatAccount.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_4 = 'children.children.children.seatAccount.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_5 = 'children.children.children.children.seatAccount.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_6 = 'children.children.children.children.children.seatAccount.seating';

        /**
        * Se realiza la consulta de cada cuenta y asiento que pertenezca a INGRESOS Y GASTOS
        */
        $records = AccountingAccount::with($level_1, $level_2, $level_3, $level_4, $level_5, $level_6)
            ->with([$level_1 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_2 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_3 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_4 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_5 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_6 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->where([
                ['group', '>=', 5],
                ['group', '<=', 6]
            ])
            ->where('subgroup', 0)
            ->orderBy('group', 'ASC')->orderBy('subgroup', 'ASC')->orderBy('item', 'ASC')->orderBy('generic', 'ASC')->orderBy('specific', 'ASC')->orderBy('subspecific', 'ASC')->get();

        $records = $this->FormatDataInArray($records);
        
        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.google.com']);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de estado de resultados');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.state_of_results', true, [
            'pdf' => $pdf,
            'records' => $records,
            'currency' => $currency,
            'level' => $level,
            'zero' => $zero,
            'endDate' => $endDate,
        ]);
    }
    
    /**
     * sintetiza la información de una cuenta en un array con sus respectivas subcuentas
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Object $records registro de una cuenta o subcuenta patrimonial
     * @param Int $level contador que indica el nivel de profundidad de la recursividad para obtener subcuentas de una cuenta
     * @return Array $parent arreglo asociativo con la información necesario de la cuenta
     */
    public function FormatDataInArray($records, $level = 1)
    {
        /** @var Array arreglo en el qe se formatea la información pertinente de la consultar */
        $parent = [];

        /** @var Int contador para ubicar la posición del tipo de cuenta base */
        $pos = 0;

        /** condición de parada del ultimo nivel */
        if ($level > 6) {
            return [];
        }

        if (count($records) > 0) {
            foreach ($records as $account) {
                array_push($parent, [
                    'code' => $account->getCodeAttribute(),
                    'denomination' => $account->denomination,
                    'balance' => $this->calculateValuesInSeating($account),
                    'level' => $level,
                    'children' => [],
                    'show_children' => false,
                ]);
                $parent[$pos]['children'] = $this->FormatDataInArray($account->children, $level+1);

                /**
                * El atributo 'show_children' se establece que si la cuenta tiene hijos estos se mostraran por omisión
                * aun si no se deseanmostrar cuentas con saldo 0
                */
                $parent[$pos]['show_children'] = (count($parent[$pos]['children']) > 0)?false:true;
                $pos++;
            }
            return $parent;
        }
        return [];
    }

    /**
     * realiza el calculo de saldo de la cuenta tomando en cuenta todos sus subcuentas, hasta llegar al ultimo nivel de parentela
     * solo se sumaran los valores de los asientos contables aprobados
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Object $records registro de una cuenta o subcuenta patrimonial
     * @return Float resultado de realizar la operaciones de suma y resta
     */

    public function calculateValuesInSeating($account)
    {
        /** @var Float saldo total en el debe de la cuenta */
        $debit = 0;

        /** @var Float saldo total en el haber de la cuenta */
        $assets = 0;

        /** @var Float saldo total de la suma de los saldos de sus cuentas hijo */
        $balanceChildren = 0;

        foreach ($account->seatAccount as $seatAccount) {
            if ($seatAccount->seating['approved']) {
                $debit += (float)$seatAccount['debit'];
                $assets += (float)$seatAccount['assets'];
            }
        }
        if (count($account->children) > 0) {
            foreach ($account->children as $child) {
                /**
                * llamada recursiva y acumulación
                */
                $balanceChildren += $this->calculateValuesInSeating($child);
            }
        }
        /**
        * si pertenece a los ingresos aumento por el haber
        */
        if ($account->group === '5') {
            return (($assets - $debit) + $balanceChildren);
        } elseif ($account->group === '6') {
            return (($debit - $assets) + $balanceChildren);
        }
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}