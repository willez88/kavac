<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use DateTime;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;

use App\Repositories\ReportRepository;
use App\Models\Institution;

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

class AccountingAnalyticalMajorController extends Controller
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
    public function filterAccounts($initDate, $endYear, $endMonth)
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
         * [$query consulta de las cuentas con relación hacia asientos contables aprobados en un rango de fecha]
         * @var [Modules\Accounting\Models\AccountingAccount]
         */
        $query = AccountingAccount::with(['seatAccount.seating' => function ($query) use ($initDate, $endDate) {
            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            }
        }])->whereHas('seatAccount.seating', function ($query) use ($initDate, $endDate) {
            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
        })
        ->orderBy('group', 'ASC')
        ->orderBy('subgroup', 'ASC')
        ->orderBy('item', 'ASC')
        ->orderBy('generic', 'ASC')
        ->orderBy('specific', 'ASC')
        ->orderBy('subspecific', 'ASC')
        ->orderBy('denomination', 'ASC')->get();

        /**
         * [$arrAccounts cuentas patrimoniales en array asociativo]
         * @var array
         */
        $arrAccounts = [];

        /**
        Se formatean los datos de las cuentas
        */
        array_push($arrAccounts, [
                'id' => 0,
                'text' => 'Seleccione...',
            ]);

        foreach ($query as $account) {
            if ($account['seatAccount']) {
                array_push($arrAccounts, [
                    'text' => "{$account->getCodeAttribute()} - {$account->denomination}",
                    'id' => $account->id,
                ]);
            }
        }
        return $arrAccounts;
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
        return response()->json(['records' => $this->filterAccounts(
            $request->initYear.'-'.$request->initMonth,
            $request->endYear,
            $request->endMonth
        )]);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate [rango de fecha inicial YYYY-mm]
     * @param String $endDate [rango de fecha final YYYY-mm]
     * @param String $initAcc  [id de cuenta patrimonial inicial]
     * @param String $endAcc   [id de cuenta patrimonial final]
     */
    public function pdf($initDate, $endDate, $initAcc, $endAcc)
    {
        /**
         * [$query almacenara la consulta]
         * @var array
         */
        $query = [];

        /**
         * [$url link para consultar ese regporte]
         * @var string
         */
        $url = 'analyticalMajor/pdf/'.$initDate.'/'.$endDate.'/'.$initAcc.'/'.$endAcc;

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
                                        ->where('report', 'Mayor Analítico')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            AccountingReportHistory::create(
                [
                    'report' => 'Mayor Analítico',
                    'url' => $url,
                ]
            );
        } else {
            $report->url = $url;
            $report->save();
        }

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
         * [$records registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $records = AccountingAccount::with(['seatAccount.seating' => function ($query) use ($initDate, $endDate) {
            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            }
        }])
            ->whereBetween('id', [$initAcc, $endAcc])
            ->whereHas('seatAccount.seating', function ($query) use ($initDate, $endDate) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            })
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

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

        $initDate = new DateTime($initDate);
        $endDate = new DateTime($endDate);

        $initDate = $initDate->format('d/m/Y');
        $endDate = $endDate->format('d/m/Y');

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
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de mayor analítico');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.analytical_major', true, [
            'pdf' => $pdf,
            'records' => $records,
            'initDate' => $initDate,
            'endDate' => $endDate,
            'currency' => $currency,
        ]);
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
