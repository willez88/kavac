<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\ExchangeRate;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Profile;
use Modules\Accounting\Models\Setting;

use App\Repositories\ReportRepository;
use DateTime;
use Auth;

/**
 * @class AccountingReportPdfAuxiliaryBookController
 * @brief Controlador para la generación del reporte de libro auxiliar
 *
 * Clase que gestiona el reporte de libro auxiliar
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAuxiliaryBookController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.auxiliarybook', ['only' => ['index', 'pdf', 'pdfVue']]);
    }

    /**
     * [pdfVue verifica las conversiones monetarias de un reporte de libro auxiliar]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param string $account_id [variable con el id de la cuenta]
     * @param string $date       [fecha para la generación de reporte, formato 'YYYY-mm']
     * @param Currency $currency moneda en que se expresara el reporte
     */
    public function pdfVue($date, Currency $currency, $account_id = null)
    {
        /**
         * [$initDate fecha inicial de busqueda]
         * @var string
         */
        $initDate = $date.'-01';

        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate fecha final de busqueda]
         * @var string
         */
        $endDate     = $date.'-'.$day;

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        $is_admin = auth()->user()->isAdmin();

        $convertions = [];

        if (!$account_id) {
            /**
             * [$query cuenta patrimonial con su relacion en asientos contables]
             * @var [Modules\Accounting\Models\AccountingEntry]
             */
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
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
            ->where('group', '>', 0)
            ->where('subgroup', '>', 0)
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

            foreach ($query as $account) {
                /*
                 * Se recorre y evalua la relacion en las conversiones necesarias a realizar
                 */
                foreach ($account['entryAccount'] as $entryAccount) {
                    $inRange = false;
                    if ($entryAccount['entries']) {
                        if (!array_key_exists(
                            $entryAccount['entries']['currency']['id'],
                            $convertions
                        )) {
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

                        if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                                    && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                            return response()->json([
                                    'result'  => false,
                                    'message' => 'Imposible expresar saldos de '.
                                                 $entryAccount['entries']['currency']['symbol']
                                                 .' ('.$entryAccount['entries']['currency']['name'].')'
                                                 .' a '.$currency['symbol'].'('.$currency['name'].')'.
                                                 ', verificar tipos de cambio configurados.'.
                                                 ' Para la fecha de '.
                                                 $entryAccount['entries']['from_date'],
                              ], 200);
                        } elseif (!$inRange) {
                            if ($entryAccount['entries']['currency']['id'] != $currency['id']) {
                                return response()->json([
                                    'result'  => false,
                                    'message' => 'Imposible expresar saldos de '.
                                                 $entryAccount['entries']['currency']['symbol']
                                                 .' ('.$entryAccount['entries']['currency']['name'].')'
                                                 .' a '.$currency['symbol'].'('.$currency['name'].')'.
                                                 ', verificar tipos de cambio configurados.'.
                                                 ' Para la fecha de '.
                                                 $entryAccount['entries']['from_date'],
                                ], 200);
                            }
                        }
                    }
                }
            }
        } elseif ($account_id) {
            $account = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
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
                }])->find($account_id);
            /*
             * Se recorre y evalua la relacion en las conversiones necesarias a realizar
             */
            foreach ($account['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists(
                        $entryAccount['entries']['currency']['id'],
                        $convertions
                    )) {
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

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                        && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                        return response()->json([
                            'result'  => false,
                            'message' => 'Imposible expresar saldos de '.
                                         $entryAccount['entries']['currency']['symbol']
                                         .' ('.$entryAccount['entries']['currency']['name'].')'
                                         .' a '.$currency['symbol'].'('.$currency['name'].')'.
                                         ', verificar tipos de cambio configurados.'.
                                         ' Para la fecha de '.
                                         $entryAccount['entries']['from_date'],
                        ], 200);
                    } elseif (!$inRange) {
                        if ($entryAccount['entries']['currency']['id'] != $currency['id']) {
                            return response()->json([
                                'result'  => false,
                                'message' => 'Imposible expresar saldos de '.
                                             $entryAccount['entries']['currency']['symbol']
                                             .' ('.$entryAccount['entries']['currency']['name'].')'
                                             .' a '.$currency['symbol'].'('.$currency['name'].')'.
                                             ', verificar tipos de cambio configurados.'.
                                             ' Para la fecha de '.
                                             $entryAccount['entries']['from_date'],
                            ], 200);
                        }
                    }
                }
            }
        }

        /**
         * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'auxiliaryBook/'.$date.'/'.$account_id;

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
                                        ->where('report', 'Libro Auxiliar')
                                        ->where('institution_id', $institution_id)->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report'      => 'Libro Auxiliar',
                    'url'         => $url,
                    'currency_id' => $currency->id,
                    'institution_id' => $institution_id,
                ]
            );
        } else {
            $report->url         = $url;
            $report->currency_id = $currency->id;
            $report->institution_id = $institution_id;
            $report->save();
        }

        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $report [id de reporte y su informacion]
     */
    public function pdf($report)
    {
        $report     = AccountingReportHistory::with('currency')->find($report);
        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
        if ($report && $report->queryAccess($user_profile['institution']['id'])) {
            return view('errors.403');
        }
        $date       = explode('/', $report->url)[1];
        $account_id = explode('/', $report->url)[2];
        $initMonth  = (int)explode('-', $date)[1];
        $initYear   = (int)explode('-', $date)[0];

        if ($initMonth < 10) {
            $initMonth = '0'.$initMonth;
        }
        $date     = $initYear.'-'.$initMonth;

        $currency = $report->currency;

        /**
         * [$initDate fecha inicial de busqueda]
         * @var string
         */
        $initDate = $date.'-01';

        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate fecha final de busqueda]
         * @var string
         */
        $endDate = $date.'-'.$day;

        $institution_id = null;

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        $is_admin = auth()->user()->isAdmin();

        $convertions = [];
        if (!$account_id) {
            // todas las cuentas auxiliares
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
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
            ->where('group', '>', '0')
            ->where('subgroup', '>', '0')
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

            $acc  = [];
            $cont = 0;
            foreach ($query as $account) {
                array_push($acc, [
                    'id'           => $account['id'],
                    'denomination' => $account['denomination'],
                    'code'         => $account->getCodeAttribute(),
                    'entryAccount' => [],
                ]);
                /*
                 * Se recorre y evalua la relacion en las conversiones necesarias a realizar
                 */
                foreach ($account['entryAccount'] as $entryAccount) {
                    if ($entryAccount['entries']) {
                        $r = [
                                'debit'      => '0',
                                'assets'     => '0',
                                'entries'    => [
                                    'reference'  => $entryAccount['entries']['reference'],
                                    'concept'    => $entryAccount['entries']['concept'],
                                    'created_at' => $entryAccount['entries']['created_at']->format('d/m/Y'),
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
                        array_push($acc[$cont]['entryAccount'], $r);
                    }
                }
                $cont++;
            }
        } elseif ($account_id) {
            // Una sola cuenta auxiliar
            $account = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
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
                }])->find($account_id);

            $acc[0] = [
                'id'             => $account['id'],
                'denomination'   => $account['denomination'],
                'code'           => $account->getCodeAttribute(),
                'entryAccount'   => [],
            ];
            /*
             * recorrido y formateo de informacion en arreglos para mostrar en pdf
             */
            foreach ($account['entryAccount'] as $entryAccount) {
                if ($entryAccount['entries']) {
                    $r = [
                            'debit'      => '0',
                            'assets'     => '0',
                            'entries'    => [
                                'reference'  => $entryAccount['entries']['reference'],
                                'concept'    => $entryAccount['entries']['concept'],
                                'created_at' => $entryAccount['entries']['created_at']->format('d/m/Y'),
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

                    array_push($acc[0]['entryAccount'], $r);
                }
            }
        }
        /**
         * [$setting configuración general de la aplicación]
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
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/auxiliaryBook/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de libro Auxiliar');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.auxiliary_book', true, [
            'pdf'      => $pdf,
            'record'   => $acc,
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
