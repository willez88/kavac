<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntryAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\ExchangeRate;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;

use App\Repositories\ReportRepository;
use App\Models\Institution;
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
        $endDate = $date.'-'.$day;

        $convertions = [];
        /**
         * [$query cuenta patrimonial con su relacion en asientos contables]
         * @var [Modules\Accounting\Models\AccountingEntry]
         */
        if ($account_id == -1) {
            $account = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                }
            }])
            ->where('group', '>', 0)
            ->where('subgroup', '>', 0)
            ->where('item', '>', 0)
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
                    if ($entryAccount['entries'] &&
                        !array_key_exists(
                            $entryAccount['entries']['currency']['id'],
                            $convertions
                        )
                    ) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency['id']
                        );

                        if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                            && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                            return response()->json([
                                                    'result'  =>false,
                                                    'message' =>'Imposible expresar '.
                                                    $entryAccount['entries']['currency']['symbol']
                                                    .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                    ', verificar tipos de cambio configurados. '
                                    ], 200);
                        }
                    }
                }
            }
        } elseif ($account_id) {
            $account = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                }
            }])->find($account_id);
            /*
             * Se recorre y evalua la relacion en las conversiones necesarias a realizar
             */
            foreach ($account['entryAccount'] as $entryAccount) {
                if ($entryAccount['entries'] && !array_key_exists(
                    $entryAccount['entries']['currency']['id'],
                    $convertions
                )) {
                    $convertions = $this->calculateExchangeRates(
                        $convertions,
                        $entryAccount['entries'],
                        $currency['id']
                    );

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                        && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                        return response()->json([
                                    'result'=>false,
                                    'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                ', verificar tipos de cambio configurados. '
                                ], 200);
                    }
                }
            }
        }

        /**
         * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'auxiliaryBook/pdf/'.$date.'/'.$account_id;

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
                                        ->where('report', 'Libro Auxiliar')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report'      => 'Libro Auxiliar',
                    'url'         => $url,
                    'currency_id' => $currency->id,
                ]
            );
        } else {
            $report->url         = $url;
            $report->currency_id = $currency->id;
            $report->save();
        }

        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id [id de reporte y su informacion]
     */
    public function pdf($report)
    {
        $report = AccountingReportHistory::with('currency')->find($report);
        $date  = explode('/', $report->url)[2];
        $account_id = explode('/', $report->url)[3];
        $initMonth = (int)explode('-', $date)[1];
        $initYear = (int)explode('-', $date)[0];

        if ($initMonth < 10) {
            $initMonth = '0'.$initMonth;
        }
        $date = $initYear.'-'.$initMonth;

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

        $convertions = [];
        /**
         * [$account cuenta patrimonial con su relacion en asientos contables]
         * @var [Modules\Accounting\Models\AccountingEntry]
         */
        if (!$account_id) {
            // todas las cuentas auxiliares
            $query = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                }
            }])
            ->where('group', '>', '0')
            ->where('subgroup', '>', '0')
            ->where('item', '>', '0')
            ->where('id', '<', 50)
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

            $acc = [];
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
                                            ($entryAccount['entries']['currency']['id'] != $currency['id'])??true
                                        ):0;

                        $r['assets'] = ($entryAccount['assets'] != 0)?
                                        $this->calculateOperation(
                                            $convertions,
                                            $entryAccount['entries']['currency']['id'],
                                            $entryAccount['assets'],
                                            ($entryAccount['entries']['currency']['id'] != $currency['id'])??true
                                        ):0;
                        array_push($acc[$cont]['entryAccount'], $r);
                    }
                }
                $cont++;
            }
        } elseif ($account_id) {
            // Una sola cuenta auxiliar
            $account = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
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
                                        ($entryAccount['entries']['currency']['id'] != $currency['id'])??true
                                    ):0;

                    $r['assets'] = ($entryAccount['assets'] != 0)?
                                    $this->calculateOperation(
                                        $convertions,
                                        $entryAccount['entries']['currency']['id'],
                                        $entryAccount['assets'],
                                        ($entryAccount['entries']['currency']['id'] != $currency['id'])??true
                                    ):0;

                    array_push($acc[0]['entryAccount'], $r);
                }
            }
        }
        /**
         * [$setting configuración general de la aplicación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting = Setting::all()->first();
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
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/auxiliaryBook/pdf/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de libro Auxiliar');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.auxiliary_book', true, [
            'pdf' => $pdf,
            'record' => $acc,
            'initDate' => $initDate,
            'endDate' => $endDate,
            'currency' => $currency,
        ]);
    }

    /**
     * [calculateOperation realiza la conversion de saldo]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array   $convertions   [lista de tipos cambios para la moneda]
     * @param  integer $entry_id      [identificador del asiento]
     * @param  float   $value         [saldo del asiento]
     * @param  boolean $equalCurrency [bandera que indica si el tipo de moneda en el que esta el asiento es las misma
     *                                que la que se desea expresar]
     * @return float                  [resultdado de la operacion]
     */
    public function calculateOperation($convertions, $currency_id, $value, $equalCurrency)
    {
        if (!$equalCurrency) {
            return $value;
        }
        if ($currency_id && array_key_exists($currency_id, $convertions) && $convertions[$currency_id]) {
            if ($convertions[$currency_id]['operator'] == 'to') {
                return ($value * $convertions[$currency_id]['amount']);
            } else {
                return ($value / $convertions[$currency_id]['amount']);
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
        $exchangeRate = ExchangeRate::where('start_at', '<=', $entry['from_date'])
                             ->where('end_at', '>=', $entry['from_date'])
                             ->where('active', true)
                             ->where('from_currency_id', $entry['currency']['id'])
                             ->where('to_currency_id', $currency_id)
                             ->orderBy('end_at', 'DESC')->first();
        if (!$exchangeRate) {
            $exchangeRate = ExchangeRate::where('start_at', '<=', $entry['from_date'])
                         ->where('end_at', '>=', $entry['from_date'])
                         ->where('active', true)
                         ->where('to_currency_id', $entry['currency']['id'])
                         ->where('from_currency_id', $currency_id)
                         ->orderBy('end_at', 'DESC')->first();
            if ($exchangeRate) {
                if (!array_key_exists($entry['currency']['id'], $convertions)) {
                    $convertions[$entry['currency']['id']] = [
                                                'amount'   => $exchangeRate->amount,
                                                'operator' => 'from'
                                            ];
                }
            }
        } else {
            if (!array_key_exists($entry['currency']['id'], $convertions)) {
                $convertions[$entry['currency']['id']] = [
                                                'amount'   => $exchangeRate->amount,
                                                'operator' => 'to'
                                            ];
            }
        }
        return $convertions;
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
