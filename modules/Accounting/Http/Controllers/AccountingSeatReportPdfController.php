<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Models\Institution;
use App\Models\Setting;

use PDF;

use Modules\Accounting\Models\AccountingSeat;

class AccountingSeatReportPdfController extends Controller
{

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */

    public function pdf($id)
    {
        // falta relación de budget_account hacia compromisos
        $seat = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->find($id);

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
        $html = \View::make('accounting::pdf.accounting_seat_pdf',compact('seat','pdf','unit'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("AsientoContable_".$seat['from_date'].".pdf");
        // return view('accounting::show');
    }

    public function get_checkBreak(){
        return $this->PageBreakTrigger;
    }

}
