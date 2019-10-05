<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;
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
    public function pdf($initDate, $endDate, Currency $currency)
    {
        $initDate = explode('-', $initDate)[2].'-'.explode('-', $initDate)[1].'-'.explode('-', $initDate)[0];
        $endDate  = explode('-', $endDate)[2].'-'.explode('-', $endDate)[1].'-'.explode('-', $endDate)[0];
        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'dailyBook/pdf/'.$initDate.'/'.$endDate;
        AccountingReportHistory::updateOrCreate(
            [
                                                    'url' => $url,
                                                ],
            [
                                                    'report' => 'Libro Diario',
                                                ]
        );

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
        
        /** @var Objet objeto con la información del asiento contable */
        $entries = AccountingEntry::with(
            'accountingAccounts.account.accountConverters.budgetAccount',
            'currency'
        )->where('approved', true)
        ->whereBetween("from_date", [$initDate, $endDate])
        ->orderBy('from_date', 'ASC')->get();

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        // $currency = Currency::find();

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
            'pdf' => $pdf,
            'entries' => $entries,
            'currency' => $currency,
            'Entry' => $Entry,
        ]);
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
