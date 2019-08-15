<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

/**
 * @class AccountingReportPdfDailyBookController
 * @brief Controlador para la generación del reporte del libro diario
 *
 * Clase que gestiona el reporte de libro diario
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingReportPdfDailyBookController extends Controller
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
     * vista en la que se genera el reporte en pdf del libro diario
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     */
    public function pdf($initDate, $endDate)
    {
        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'diaryBook/pdf/'.$initDate.'/'.$endDate;
        AccountingReportHistory::updateOrCreate(
            [
                                                    'name' => 'Libro Diario',
                                                    'report' => 3
                                                ],
            [
                                                    'url' => $url,
                                                ]
        );

        /** @var Objet objeto con la información del asiento contable */
        $seats = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->where('approved', true)->whereBetween("from_date", [$initDate, $endDate])->orderBy('from_date', 'ASC')->get();

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

        $pdf->setType('Libro Diario');
        $pdf->Open();
        $pdf->AddPage();

        $Seating = false;
        $html = \View::make('accounting::pdf.accounting_seat_and_daily_book_pdf', compact('pdf', 'seats', 'Seating', 'currency'))->render();
        $pdf->SetFont('Courier', 'B', 8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("Libro_Diario_{$initDate}_{$endDate}.pdf");
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
