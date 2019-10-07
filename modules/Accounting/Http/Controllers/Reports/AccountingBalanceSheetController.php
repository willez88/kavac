<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use Auth;
use DateTime;

/**
 * @class AccountingReportPdfBalanceSheetController
 * @brief Controlador para la generación del reporte de balance general
 *
 * Clase que gestiona el reporte de balance general
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingBalanceSheetController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.balancesheet', ['only' => ['pdf']]);
    }

    /**
     * [pdf genera el reporte en pdf de balance general]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  string   $date     [fecha]
     * @param  string   $level    [nivel de sub cuentas maximo a mostrar]
     * @param  Currency $currency [moneda en que se expresara el reporte]
     * @param  boolean  $zero     [si se tomaran cuentas con saldo cero]
     */
    public function pdf($date, $level, Currency $currency, $zero = false)
    {
        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
       
        /**
         * [$url link para el reporte]
         * @var string
         */
        $url = 'balanceSheet/pdf/'.$date.'/'.$level.'/'.$zero;

        $currentDate = new DateTime;
        $currentDate = $currentDate->format('Y-m-d');

        /**
         * [$report almacena el registro del reporte del dia si existe]
         * @var [type]
         */
        $report = AccountingReportHistory::whereBetween('updated_at', [
                                                                        $currentDate.' 00:00:00',
                                                                        $currentDate.' 23:59:59'
                                                                    ])
                                        ->where('report', 'Balance General')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            AccountingReportHistory::create(
                [
                    'report' => 'Balance General',
                    'url' => $url,
                ]
            );
        } else {
            $report->url = $url;
            $report->save();
        }
        
        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var [type]
         */
        $endDate = $date.'-'.$day;

        /**
         * [$level_1 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_1 = 'entryAccount.entries';

        /**
         * [$level_2 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_2 = 'children.entryAccount.entries';

        /**
         * [$level_3 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_3 = 'children.children.entryAccount.entries';

        /**
         * [$level_4 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_4 = 'children.children.children.entryAccount.entries';

        /**
         * [$level_5 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_5 = 'children.children.children.children.entryAccount.entries';

        /**
         * [$level_6 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_6 = 'children.children.children.children.children.entryAccount.entries';

        /**
         * Se realiza la consulta de cada cuenta y asiento que pertenezca a ACTIVO, PASIVO, PATRIMONIO y CUENTA DE ORDEN
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
            ->whereBetween('group', [0, 4])
            ->where('subgroup', 0)
            ->orderBy('subgroup', 'ASC')
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')->get();

        /**
         * [$records con los registros de las cuentas]
         * @var array
         */
        $records = $this->FormatDataInArray($records);

        /**
         * [$setting configuración general de la apliación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting = Setting::all()->first();

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
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de Balance General');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.balance_sheet', true, [
            'pdf' => $pdf,
            'records' => $records,
            'currency' => $currency,
            'level' => $level,
            'zero' => $zero,
            'endDate' => $endDate,
        ]);
    }

    /**
     * [FormatDataInArray sintetiza la información de una cuenta en un array con sus respectivas subcuentas]
     * @param  [Modules\Accounting\Models\AccountingAccount] $records registro de una cuenta o subcuenta patrimonial
     * @param  [int] $level [contador que indica el nivel de profundidad de la recursividad
     *                       para obtener subcuentas de una cuenta]
     * @return [array] arreglo asociativo con la información necesario de la cuenta
     */
    public function FormatDataInArray($records, $level = 1)
    {
        /**
         * [$parent información pertinente de la consultar]
         * @var array
         */
        $parent = [];

        /**
         * [$pos posición de la cuenta base]
         * @var integer
         */
        $pos = 0;

        /**
         * condición de parada del ultimo nivel
         */
        if ($level > 6) {
            return [];
        }

        if (count($records) > 0) {
            foreach ($records as $account) {
                array_push($parent, [
                    'code' => $account->getCodeAttribute(),
                    'denomination' => $account->denomination,
                    'balance' => $this->calculateValuesInEntries($account),
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
     * [calculateValuesInEntries realiza el calculo de saldo de la cuenta tomando en cuenta todos sus subcuentas,
     *                           hasta llegar al ultimo nivel de parentela solo se sumaran los valores de los asientos
     *                           contables aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param [Modules\Accounting\Models\AccountingAccount] $account [registro de una cuenta o subcuenta patrimonial]
     * @return [float] [resultado de realizar la operaciones de suma y resta]
     */
    public function calculateValuesInEntries($account)
    {
        /**
         * [$debit saldo total en el debe de la cuenta]
         * @var float
         */
        $debit = 0.00;

        /**
         * [$assets saldo total en el haber de la cuenta]
         * @var float
         */
        $assets = 0.00;

        /**
         * [$balanceChildren saldo total de la suma de los saldos de sus cuentas hijo]
         * @var float
         */
        $balanceChildren = 0.00;

        foreach ($account->entryAccount as $entryAccount) {
            if ($entryAccount->entries['approved']) {
                $debit += (float)$entryAccount['debit'];
                $assets += (float)$entryAccount['assets'];
            }
        }
        if (count($account->children) > 0) {
            foreach ($account->children as $child) {
                /**
                * llamada recursiva y acumulación
                */
                $balanceChildren += $this->calculateValuesInEntries($child);
            }
        }
        
        /**
        * si pertenece a los activos aumento por el haber
        */
        if ($account->group === '1') {
            return (($assets - $debit) + $balanceChildren);
        } else {
            return (($debit - $assets) + $balanceChildren);
        }
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
