<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

/**
 * @class AccountingReportPdfBalanceSheetController
 * @brief Controlador para la generación del reporte de balance general
 *
 * Clase que gestiona el reporte de balance general
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingReportPdfBalanceSheetController extends Controller
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
        $url = 'balanceSheet/pdf/'.$date.'/'.$level.'/'.$zero;
        AccountingReportHistory::updateOrCreate(
            [
                                                    'name' => 'Balance General',
                                                    'report' => 5
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
        $level_1 = 'seat_account.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_2 = 'children.seat_account.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_3 = 'children.children.seat_account.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_4 = 'children.children.children.seat_account.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_5 = 'children.children.children.children.seat_account.seating';

        /** @var Object String en el que se establece la consulta de ralación que se desean realizar  */
        $level_6 = 'children.children.children.children.children.seat_account.seating';

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
            ->where([
                ['group', '>=', 0],
                ['group', '<=', 4]
            ])
            ->where('subgroup', 0)
            ->orderBy('group', 'ASC')->orderBy('subgroup', 'ASC')->orderBy('item', 'ASC')->orderBy('generic', 'ASC')->orderBy('specific', 'ASC')->orderBy('subspecific', 'ASC')->get();

        $records = $this->FormatDataInArray($records);

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();

        /** @var Object Objeto base para generar el pdf */
        $pdf = new Pdf('L', 'mm', 'Letter');
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true) {
            $pdf->SetMargins(10, 65, 10);
        } else {
            $pdf->SetMargins(10, 55, 10);
        }
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);

        $pdf->setType('Balance General');
        $pdf->Open();
        $pdf->AddPage();

        $html = \View::make('accounting::pdf.accounting_balance_sheet_pdf', compact('pdf', 'records', 'currency', 'level', 'zero', 'endDate'))->render();
        $pdf->SetFont('Courier', 'B', 8);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("BalanceGeneral_al_{$endDate}.pdf");
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
                    'code' => $account->getCode(),
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

        foreach ($account->seat_account as $seat_account) {
            if ($seat_account->seating['approved']) {
                $debit += (float)$seat_account['debit'];
                $assets += (float)$seat_account['assets'];
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
