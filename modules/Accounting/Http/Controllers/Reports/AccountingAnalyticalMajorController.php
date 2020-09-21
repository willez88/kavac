<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\Profile;
use Modules\Accounting\Models\ExchangeRate;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Pdf\Pdf;

use App\Repositories\ReportRepository;
use Auth;

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
            ['only' => ['index', 'getAccAccount', 'pdf', 'pdfVue']]
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

        /**
         * [$endDate fecha final de busqueda]
         * @var [string]
         */
        $endDate = $endYear.'-'.$endMonth.'-'.$endDay;


        /**
         * [$query consulta de las cuentas con relación hacia asientos contables aprobados en un rango de fecha]
         * @var [Modules\Accounting\Models\AccountingAccount]
         */
        $query = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($initDate, $endDate) {
            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            }
        }])->whereHas('entryAccount.entries', function ($query) use ($initDate, $endDate) {
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
        * Se formatean los datos de las cuentas
        */
        array_push($arrAccounts, [
                'id'   => 0,
                'text' => 'Seleccione...',
            ]);

        foreach ($query as $account) {
            if ($account['entryAccount']) {
                array_push($arrAccounts, [
                    'text' => "{$account->getCodeAttribute()} - {$account->denomination}",
                    'id'   => $account->id,
                ]);
            }
        }
        return $arrAccounts;
    }

    /**
     * [getAccAccount ruta para actualizar el listado de cuentas patrimoniales en un rango de fecha determinado]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  {Request} $request [datos del rango de busqueda de las cuentas]
     * @return Renderable [cuentas patrimoniales]
     */
    public function getAccAccount(Request $request)
    {
        $this->validate($request, [
            'initMonth' => ['required'],
            'initYear'  => ['required'],
            'endMonth'  => ['required'],
            'endYear'   => ['required'],
        ]);

        return response()->json(['records' => $this->filterAccounts(
            $request->initYear.'-'.$request->initMonth,
            $request->endYear,
            $request->endMonth
        )]);
    }


    /**
     * [pdfVue verifica las conversiones monetarias de un reporte de mayor analitico]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate [rango de fecha inicial YYYY-mm]
     * @param String $endDate [rango de fecha final YYYY-mm]
     * @param String $initAcc  [id de cuenta patrimonial inicial]
     * @param String $endAcc   [id de cuenta patrimonial final]
     * @param Currency $currency moneda en que se expresara el reporte
     */
    public function pdfVue($initDate, $endDate, $initAcc, $endAcc, Currency $currency)
    {
        $initDate = $initDate.'-01';

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
            $endAcc  = (int)$endAcc;
            $aux     = $initAcc;
            $initAcc = $endAcc;
            $endAcc  = $aux;
        }

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }
        $is_admin = auth()->user()->isAdmin();

        /**
         * [$query registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $query = AccountingAccount::with(['entryAccount.entries' =>
                function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                            ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                            ->where('institution_id', $institution_id);
                        }
                    } else {
                        if ($is_admin) {
                            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                            }
                        }
                    }
                }])
            ->whereBetween('id', [$initAcc, $endAcc])
            ->whereHas(
                'entryAccount.entries',
                function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                        ->where('institution_id', $institution_id);
                    } else {
                        if ($is_admin) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                }
            )->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC');

        $convertions = [];

        /*
         * Se recorre y evalua la relacion en las conversiones necesarias a realizar
         */
        foreach ($query as $record) {
            /**
             * [$inRange indica si la fecha del asiento esta en el rango de alguna conversion]
             * @var boolean
             */
            $cont = 0;
            foreach ($record['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions) &&
                        $entryAccount['entries']['currency']['id'] != $currency->id) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency['id']
                        );
                    }

                    foreach ($convertions as $convertion) {
                        foreach ($convertion as $convert) {
                            if ($entryAccount['entries']['from_date'] >= $convert['start_at'] &&
                                $entryAccount['entries']['from_date'] <= $convert['end_at']) {
                                $inRange = true;
                            }
                        }
                    }

                    if ((!$inRange || !array_key_exists($entryAccount['entries']['currency']['id'], $convertions)) &&
                        $entryAccount['entries']['currency']['id'] != $currency['id']) {
                        return response()->json([
                                    'result'  => false,
                                    'message' => 'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                 .' ('.$entryAccount['entries']['currency']['name'].')'
                                                 .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                 ', verificar tipos de cambio configurados. Para la fecha de '.
                                                 $entryAccount['entries']['from_date'],
                                ], 200);
                    }
                }
            }
        }

        /**
         * [$url link para consultar ese regporte]
         * @var string
         */
        $url = 'analyticalMajor/'.$initDate.'/'.$endDate.'/'.$initAcc.'/'.$endAcc;

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
                                        ->where('report', 'Mayor Analítico')
                                        ->where('institution_id', $institution_id)->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report'         => 'Mayor Analítico',
                    'url'            => $url,
                    'currency_id'    => $currency->id,
                    'institution_id' => $institution_id,
                ]
            );
        } else {
            $report->url            = $url;
            $report->currency_id    = $currency->id;
            $report->institution_id = $institution_id;
            $report->save();
        }

        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }


    /**
     * [pdf vista en la que se genera el reporte en pdf]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $report [id de reporte y su informacion]
     */
    public function pdf($report)
    {
        $report   = AccountingReportHistory::with('currency')->find($report);

        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
        if ($report && $report->queryAccess($user_profile['institution']['id'])) {
            return view('errors.403');
        }

        $initDate = explode('/', $report->url)[1];
        $endDate  = explode('/', $report->url)[2];
        $initAcc  = explode('/', $report->url)[3];
        $endAcc   = explode('/', $report->url)[4];

        $currency = $report->currency;

        if (isset($endAcc) && $endAcc < $initAcc) {
            $endAcc  = (int)$endAcc;
            $aux     = $initAcc;
            $initAcc = $endAcc;
            $endAcc  = $aux;
        }

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }
        $is_admin = auth()->user()->isAdmin();

        /**
         * [$query registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $query = AccountingAccount::with(['entryAccount.entries' =>
                function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                            ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                            ->where('institution_id', $institution_id);
                        }
                    } else {
                        if ($is_admin) {
                            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                            }
                        }
                    }
                }])
            ->whereBetween('id', [$initAcc, $endAcc])
            ->whereHas(
                'entryAccount.entries',
                function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                        ->where('institution_id', $institution_id);
                    } else {
                        if ($is_admin) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                }
            )->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

        $convertions = [];
        $records     = [];

        /*
         * recorrido y formateo de informacion en arreglos para mostrar en pdf
         */
        foreach ($query as $record) {
            $acc = [
                        'denomination' => $record['denomination'],
                        'entryAccount' => [],
                    ];
            foreach ($record['entryAccount'] as $entryAccount) {
                if ($entryAccount['entries']) {
                    $from_date = explode('-', $entryAccount['entries']['from_date'])[2].'/'.
                                 explode('-', $entryAccount['entries']['from_date'])[1].'/'.
                                 explode('-', $entryAccount['entries']['from_date'])[0];

                    $r = [
                            'debit'      => '0',
                            'assets'     => '0',
                            'entries'    => [
                                'reference'  => $entryAccount['entries']['reference'],
                                'concept'    => $entryAccount['entries']['concept'],
                                'created_at' => $from_date,
                            ],
                        ];

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency['id']
                        );
                    }

                    $r['debit'] = ($entryAccount['debit'] != 0)?
                                    $this->calculateOperation(
                                        $convertions,
                                        $entryAccount['entries']['currency']['id'],
                                        $entryAccount['debit'],
                                        $entryAccount['entries']['from_date'],
                                        ($entryAccount['entries']['currency']['id'] == $currency['id'])??false
                                    ):0;

                    $r['assets'] = ($entryAccount['assets'] != 0)?
                                    $this->calculateOperation(
                                        $convertions,
                                        $entryAccount['entries']['currency']['id'],
                                        $entryAccount['assets'],
                                        $entryAccount['entries']['from_date'],
                                        ($entryAccount['entries']['currency']['id'] == $currency['id'])??false
                                    ):0;

                    array_push($acc['entryAccount'], $r);
                }
            }
            array_push($records, $acc);
        }

        /**
         * [$setting configuración general de la apliación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting  = Setting::all()->first();

        $initDate = new DateTime($initDate);
        $endDate  = new DateTime($endDate);

        $initDate = $initDate->format('d/m/Y');
        $endDate  = $endDate->format('d/m/Y');

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/analyticalMajor/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de mayor analítico');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.analytical_major', true, [
            'pdf'      => $pdf,
            'records'  => $records,
            'initDate' => $initDate,
            'endDate'  => $endDate,
            'currency' => $currency,
        ]);
    }

    /**
     * [calculateOperation realiza la conversion de saldo]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array   $convertions   [lista de tipos cambios para la moneda]
     * @param  integer $entry_id      [identificador del asiento]
     * @param  float   $value         [saldo del asiento]
     * @param  float   $date         [fecha del asiento]
     * @param  boolean $equalCurrency [bandera que indica si el tipo de moneda en el que esta el asiento es las misma
     *                                que la que se desea expresar]
     * @return float                  [resultdado de la operacion]
     */
    public function calculateOperation($convertions, $currency_id, $value, $date, $equalCurrency)
    {
        if ($equalCurrency) {
            return $value;
        }

        if ($currency_id && array_key_exists($currency_id, $convertions) && $convertions[$currency_id]) {
            foreach ($convertions[$currency_id] as $convertion) {
                if ($date >= $convertion['start_at'] && $date <= $convertion['end_at']) {
                    if ($convertion['operator'] == 'to') {
                        return ($value * $convertion['amount']);
                    } else {
                        return ($value / $convertion['amount']);
                    }
                }
            }
        }
        return -1;
    }

    /**
     * [calculateExchangeRates encuentra los tipos de cambio]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array           $convertions [lista de conversiones]
     * @param  AccountingEntry $entry       [asiento contable]
     * @param  integer         $currency_id [identificador de la moneda a la cual se realizara la conversion]
     * @return array                        [lista de conversiones actualizada]
     */
    public function calculateExchangeRates($convertions, $entry, $currency_id)
    {
        $exchangeRate = ExchangeRate::where('active', true)
                            ->whereIn('to_currency_id', [$entry['currency']['id'], $currency_id])
                            ->whereIn('from_currency_id', [$entry['currency']['id'], $currency_id])
                             ->orderBy('end_at', 'DESC')->get();
        if (count($exchangeRate) != 0) {
            if (!array_key_exists($entry['currency']['id'], $convertions)) {
                $convertions[$entry['currency']['id']] = [];
                foreach ($exchangeRate as $recordExchangeRate) {
                    array_push(
                        $convertions[$entry['currency']['id']],
                        [
                            'amount'   => $recordExchangeRate->amount,
                            'operator' => ($currency_id == $recordExchangeRate->from_currency_id)?'from':'to',
                            'start_at' => $recordExchangeRate->start_at,
                            'end_at'   => $recordExchangeRate->end_at
                        ]
                    );
                }
            }
        }
        return $convertions;
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
