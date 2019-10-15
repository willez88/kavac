<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\ExchangeRate;
use App\Repositories\ReportRepository;

use Auth;
use DateTime;

/**
 * @class AccountingReportPdfDailyBookController
 * @brief Controlador para la generación del reporte del libro diario
 *
 * Clase que gestiona el reporte de libro diario
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingDailyBookController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.dailybook', ['only' => ['index', 'pdf']]);
    }
    

    /**
     * [pdf vista en la que se genera el reporte en pdf del libro diario]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     * @param Currency $currency moneda en que se expresara el reporte
     */
    public function pdfVue($initDate, $endDate, Currency $currency)
    {
        $initDateDMY = explode('-', $initDate)[2].'-'.explode('-', $initDate)[1].'-'.explode('-', $initDate)[0];
        $endDateDMY  = explode('-', $endDate)[2].'-'.explode('-', $endDate)[1].'-'.explode('-', $endDate)[0];
        
        /**
         * [$entries información del asiento contable]
         * @var AccountingEntry
         */
        $entries = AccountingEntry::with(
            'accountingAccounts.account.accountConverters.budgetAccount',
            'currency'
        )->where('approved', true)
        ->whereBetween("from_date", [$initDateDMY, $endDateDMY])
        ->orderBy('from_date', 'ASC')->get();

        $convertions = [];
        foreach ($entries as $entry) {
            $convertions = $this->calculateExchangeRates($convertions, $entry, $currency['id']);
            if (!array_key_exists($entry['id'], $convertions) && $entry['currency']['id'] != $currency['id']) {
                return response()->json([
                    'result'=>false,
                    'message'=>'Imposible expresar asiento contable '.$entry['reference']
                                .' de '.$entry['currency']['symbol']
                                .' a '.$currency['symbol'].'('.$currency['name'].')'.
                                ', verificar tipos de cambio configurados.'
                ], 200);
            }
        }

        return response()->json(['result'=>true], 200);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf del libro diario]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     * @param Currency $currency moneda en que se expresara el reporte
     */
    public function pdf($initDate, $endDate, Currency $currency)
    {
        // dd(AccountingAccount::all()->chunk(100));
        $initDateDMY = explode('-', $initDate)[2].'-'.explode('-', $initDate)[1].'-'.explode('-', $initDate)[0];
        $endDateDMY  = explode('-', $endDate)[2].'-'.explode('-', $endDate)[1].'-'.explode('-', $endDate)[0];

        $url = 'dailyBook/pdf/'.$initDateDMY.'/'.$endDateDMY.'/'.$currency['id'];

        /**
         * [$report almacena el registro del reporte del dia si existe]
         * @var [type]
         */
        $report = AccountingReportHistory::whereBetween('updated_at', [
                                                                        $initDate.' 00:00:00',
                                                                        $endDate.' 23:59:59'
                                                                    ])
                                        ->where('report', 'Libro Diario')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            AccountingReportHistory::create(
                [
                    'report' => 'Libro Diario',
                    'url' => $url,
                ]
            );
        } else {
            $report->url = $url;
            $report->save();
        }
        
        /**
         * [$entries información del asiento contable]
         * @var AccountingEntry
         */
        $entries = AccountingEntry::with(
            'accountingAccounts.account.accountConverters.budgetAccount',
            'currency'
        )->where('approved', true)
        ->whereBetween("from_date", [$initDateDMY, $endDateDMY])
        ->orderBy('from_date', 'ASC')->get();

        $convertions = [];
        $records = [];
        foreach ($entries as $entry) {
            $convertions = $this->calculateExchangeRates($convertions, $entry, $currency['id']);

            $from_date = explode('-', $entry['from_date']);
            $record = [
                'id'=>$entry['id'],
                'from_date'=> $from_date[2].'-'.$from_date[1].'-'.$from_date[0] ,
                'accountingAccounts'=>[],
            ];

            $record['accountingAccounts'] = [];
            foreach ($entry['accountingAccounts'] as $r) {
                array_push($record['accountingAccounts'], [
                    'debit'=> ($r['debit']  != 0)?
                                $this->calculateOperation(
                                    $convertions,
                                    $entry['id'],
                                    $r['debit'],
                                    ($entry['currency']['id'] != $currency['id'])??true
                                ):0,
                    'assets'=>($r['assets'] != 0)?
                                $this->calculateOperation(
                                    $convertions,
                                    $entry['id'],
                                    $r['assets'],
                                    ($entry['currency']['id'] != $currency['id'])??true
                                ):0,
                    'code'=>$r['account']->getCodeAttribute(),
                    'denomination'=>$r['account']['denomination']
                ]);
            }

            array_push($records, $record);
        }

        /**
         * [$setting configuración general de la apliación]
         * @var Setting
         */
        $setting = Setting::all()->first();

        $Entry = false;

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
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de libro diario');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.entry_and_daily_book', true, [
            'pdf'         => $pdf,
            'entries'     => $records,
            'convertions' => $convertions,
            'currency'    => $currency,
            'Entry'       => $Entry,
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
    public function calculateOperation($convertions, $entry_id, $value, $equalCurrency)
    {
        if (!$equalCurrency) {
            return $value;
        }
        if ($entry_id && array_key_exists($entry_id, $convertions) && $convertions[$entry_id]) {
            if ($convertions[$entry_id]['operator'] == 'to') {
                return ($value * $convertions[$entry_id]['amount']);
            } else {
                return ($value / $convertions[$entry_id]['amount']);
            }
        }
        return -1;
    }

    /**
     * [calculateExchangeRates encuentra el tipo de cambio para un asiento en particular]
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
                if (!array_key_exists($entry['id'], $convertions)) {
                    $convertions[$entry['id']] = [
                                                'amount'   => $exchangeRate->amount,
                                                'operator' => 'from'
                                            ];
                }
            }
        } else {
            if (!array_key_exists($entry['id'], $convertions)) {
                $convertions[$entry['id']] = [
                                                'amount'   => $exchangeRate->amount,
                                                'operator' => 'to'
                                            ];
            }
        }
        return $convertions;
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
