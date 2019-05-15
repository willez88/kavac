<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingSeat;

use App\Models\Institution;
use App\Models\Setting;

use PDF;
use Auth;

class AccountingReportPdfCheckupBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::orderBy('from_date','DESC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $yearOld = explode('-',$seating->from_date)[0];

        return view('accounting::reports.index-checkupBalance',compact('yearOld'));
    }

    public function pdf($zero)
    {
        // falta relación de budget_account hacia compromisos
        $seat = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->find(2);

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

        $pdf->setType('Balance de Comprobación');
        $pdf->Open();
        $pdf->AddPage();

        $unit = true;
        $html = \View::make('accounting::pdf.accounting_checkup_balance_pdf',compact('seat','pdf'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("Balance_de_Comprobación_".$seat['from_date'].".pdf");
    }

    public function get_checkBreak(){
        return $this->PageBreakTrigger;
    }

}
