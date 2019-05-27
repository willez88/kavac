<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\AccountingSeat;

use Modules\Accounting\Pdf\PDF;

class AccountingSeatReportPdfController extends Controller
{

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */

    public function pdf($id)
    {

        /** @var Object objeto que contendra la moneda manejada por defecto */
        $currency = Currency::where('default',true)->first();

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

        $OneSeat = true;
        $html = \View::make('accounting::pdf.accounting_seat_pdf',compact('seat','pdf','OneSeat','currency'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("AsientoContable_".$seat['from_date'].".pdf");
        // return view('accounting::show');
    }

    public function get_checkBreak(){
        return $this->PageBreakTrigger;
    }

}
