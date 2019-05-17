<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingSeat;
use App\Models\Institution;
use App\Models\Setting;

use PDF;
class AccountingReportPdfDiaryBookController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('accounting::reports.index-diaryBook');
    }

    public function pdf($dateIni, $dateEnd)
    {

        // falta relación de budget_account hacia compromisos
        $seats = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->whereBetween("from_date",[$dateIni, $dateEnd])->get();

        $setting = Setting::all()->first();

        $pdf = new \Pdf\Pdf('L','mm','Letter');
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true)
            $pdf->SetMargins(10, 65, 10);
        else
            $pdf->SetMargins(10, 55, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_FOOTER);

        $pdf->setType('Asientos Contables');
        $pdf->Open();
        $pdf->AddPage();

        $unit = true;
        $html = \View::make('accounting::pdf.accounting_seat_pdf',compact('seats','seat','pdf','unit'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("AsientoContable_".$dateIni."_".$dateEnd.".pdf");
        // return view('accounting::reports.index-diaryBook');
    }
}
