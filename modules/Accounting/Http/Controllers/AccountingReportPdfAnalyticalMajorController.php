<?php

namespace Modules\Accounting\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;

/**
 * @class AccountingReportPdfAnalyticalMajorController
 * @brief Controlador para la generación del reporte de Mayor Analítico
 *
 * Clase que gestiona el reporte de mayor analítico
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class AccountingReportPdfAnalyticalMajorController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /**
         * Establece permisos de acceso para cada método del controlador
         */
        $this->middleware(
            'permission:accounting.report.analiticalmajor',
            ['only' => ['index', 'getAccAccount', 'pdf']]
        );
    }

    /**
     * Consulta y formatea las cuentas en un rango determinado
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [integer] $initDate [fecha inicial para iniciar la busqueda, formato(YYYY-mm)]
     * @param  [integer] $endYear  [año del fin del rango de busqueda]
     * @param  [integer] $endMonth [mes del fin del rango de busqueda]
     * @return [array] [cuentas patrimoniales]
     */
    public function filter_accounts($initDate, $endYear, $endMonth)
    {

        /**
         * [$initDate fecha inicial de busqueda]
         * @var [string]
         */
        $initDate = $initDate.'-01';

        /**
         * [$endDay ultimo dia correspondiente al mes]
         * @var [date]
         */
        $endDay = date('d', (mktime(0, 0, 0, $endMonth+1, 1, $endYear)-1));

        /** @var Object string en el que se formatea la fecha final de busqueda */
        /**
         * [$endDate fecha final de busqueda]
         * @var [string]
         */
        $endDate = $endYear.'-'.$endMonth.'-'.$endDay;


        /**
         * [$RecordArr consulta de las cuentas con relación hacia asientos contables en un rango de fecha]
         * @var [Modules\Accounting\Models\AccountingSeatAccount]
         */
        $RecordArr = AccountingSeatAccount::with('seating', 'account')
                    ->whereHas('seating', function ($query) use ($initDate, $endDate) {
                        $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                    })->orderBy('updated_at', 'ASC')->get();

        /**
         * [$records cuentas patrimoniales de manera unica en el rango dado]
         * @var array
         */
        $records = [];

        /**
         * [$arrAux cuentas patrimoniales ordenadas por código]
         * @var array
         */
        $arrAux = [];

        /**
         * Ciclo los registros de cuentas relacionadas con asiento contables
        */
        foreach ($RecordArr as $accounting_accounts) {

            /**
             * [$add indica si la cuenta ya esta en el array]
             * @var boolean
             */
            $add = true;

            /**
             * Ciclo para verificar que la cuenta no se repita en el array
            */
            for ($i=0; $i < count($records); $i++) {
                if ($records[$i]->id == $accounting_accounts->account->id) {
                    $add = false;
                    break;
                }
            }

            if (count($records)==0 || $add) {
                array_push($records, $accounting_accounts->account);
            }
        }

        /**
         * [build_sorter compara y ordena las cuentas segun el orden en el código]
         * @return [integer] [resultado de la comparacion]
         */
        function build_sorter()
        {
            return function ($a, $b) {
                return strnatcmp($a->getCodeAttribute(), $b->getCodeAttribute());
            };
        }

        usort($records, build_sorter());

        /**
        Se formatean los datos de las cuentas
        */
        array_push($arrAux, [
                'id_record' => 0,
                'text' => 'Seleccione...',
                'id' => 0,
            ]);
        
        /**
         * [$index indice para listar]
         * @var integer
         */
        $index = 1;
        foreach ($records as $account) {
            array_push($arrAux, [
                'id_record' => $account->id,
                'text' => "{$account->getCodeAttribute()} - {$account->denomination}",
                'id' => $index,
            ]);
            $index += 1;
        }
        return $arrAux;
    }

    /**
     * [getAccAccount ruta para actualizar el listado de cuentas patrimoniales en un rango de fecha determinado]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  {Request} $request [datos del rango de busqueda de las cuentas]
     * @return [Response] [cuentas patrimoniales]
     */
    public function getAccAccount(Request $request)
    {
        $this->validate($request, [
            'initMonth' => 'required',
            'initYear' => 'required',
            'endMonth' => 'required',
            'endYear' => 'required',
        ]);
        return response()->json(['records' => $this->filter_accounts(
            $request->initYear.'-'.$request->initMonth,
            $request->endYear,
            $request->endMonth
        )]);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param [string] $initAcc variable con el index en el array de la cuenta de inicio
     * @param [string] $endAcc variable con el index en el array de la cuenta final
     * @param [string] $initAcc  [description]
     * @param [string] $endAcc   [description]
     */
    public function pdf($initDate, $endDate, $initAcc, $endAcc = null)
    {
        /**
         * [$date_i fecha inicial]
         * @var string
         */
        $date_i = $initDate;

        /**
         * [$date_e fecha final]
         * @var string
         */
        $date_e = $endDate;

        /**
         * [$init_a id de cuenta inicial]
         * @var string
         */
        $init_a = $initAcc;

        $initAcc = (int)$initAcc;

        /**
         * [$accountRecords información base (id, id y denomination) de las cuentas patrimoniales]
         * @var [array]
         */
        $accountRecords = $this->filter_accounts($initDate, explode('-', $endDate)[0], explode('-', $endDate)[1]);

        /**
         * [$initDate la fecha inicial de busqueda]
         * @var string
         */
        $initDate = $initDate.'-01';

        /** @var Object string en que se almacena el ultimo dia correspondiente al mes */
        /**
         * [$endDay ultimo dia correspondiente al mes]
         * @var [date]
         */
        $endDay = date('d', (mktime(0, 0, 0, explode('-', $endDate)[1]+1, 1, explode('-', $endDate)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda]
         * @var string
         */
        $endDate = explode('-', $endDate)[0].'-'.explode('-', $endDate)[1].'-'.$endDay;

        if (isset($endAcc) && $endAcc < $initAcc) {
            $endAcc = (int)$endAcc;
            $aux = $initAcc;
            $initAcc = $endAcc;
            $endAcc = $aux;
        }

        /**
         * [$EndIndex cuenta desde donde finalizara la busqueda]
         * @var [integer]
         */
        $EndIndex = $initAcc;

        if (isset($endAcc)) {
            $EndIndex = $endAcc;
        }

        /**
         * [$records registros de las cuentas patrimoniales seleccionadas]
         * @var array
         */
        $records = [];

        for (; $initAcc <= $EndIndex; $initAcc++) {
            $id = $accountRecords[$initAcc]['id_record'];
            array_push($records, AccountingSeatAccount::with('seating', 'account')
                                ->where('accounting_account_id', $id)
                                ->whereHas('seating', function ($query) use ($initDate, $endDate) {
                                    $query->whereBetween(
                                        'from_date',
                                        [$initDate,$endDate]
                                    )->where('approved', true);
                                })->orderBy('updated_at', 'ASC')->get());
        }

        /**
         * [$url link para consultar ese regporte]
         * @var string
         */
        $url = 'AnalyticalMajor/pdf/'.$date_i.'/'.$date_e.'/'.$init_a;

        if (isset($endAcc)) {
            $url .= '/'.$endAcc;
        }

        AccountingReportHistory::updateOrCreate(
            [
                                                    'name' => 'Mayor Analítico',
                                                    'report' => 2
                                                ],
            [
                                                    'url' => $url,
                                                ]
        );

        /**
         * [$setting configuración general de la apliación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting = Setting::all()->first();

        /**
         * [$currency información de la modena por defecto establecida en la aplicación]
         * @var [Modules\Accounting\Models\Currency]
         */
        $currency = Currency::where('default', true)->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
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

        $pdf->setType('Asientos Contables');
        $pdf->Open();
        $pdf->AddPage();

        $OneSeat = false;
        
        $html = \View::make('accounting::pdf.accounting_analytical_major_pdf', compact('pdf', 'records', 'initDate', 'endDate', 'currency'))->render();
        $pdf->SetFont('Courier', 'B', 8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("MayorAnalítico_{$initDate}_{$endDate}.pdf");
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
