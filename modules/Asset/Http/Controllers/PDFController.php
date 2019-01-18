<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Asset\Models\Asset;
use App\Models\Institution;
use App\Models\Setting;

class PDFController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.report.print', ['only' => 'create']);
    }

    public function create(Request $request)
    {
        $assets = Asset::codeclasification($request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        
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

        $pdf->setType(1);
        $pdf->Open();
        $pdf->AddPage();

        $view = \View::make('asset::pdf.asset_detallado',compact('assets','pdf'));
        $html = $view->render();
        $pdf->SetFont('Courier','B',8);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output("ReporteBienes_".date("d-m-Y").".pdf");
    }

    public function create_general(Request $request)
    {
        $assets = Asset::dateclasification($request->start_date,$request->end_date,$request->mes_id,$request->year_id)->get();

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

        $pdf->setType(2);
        $pdf->Open();
        $pdf->AddPage("L");

        $view = \View::make('asset::pdf.asset_general',compact('assets','pdf'));
        $html = $view->render();                
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("ReporteGeneralBienes_".date("d-m-Y").".pdf");
    }

    public function create_accouting_seat(Request $request){

        $assets = Asset::all();

        $setting = Setting::all()->first();        

        $pdf = new \Pdf\Pdf2('P','mm','Letter');
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true)
            $pdf->SetMargins(10, 50, 10);
        else
            $pdf->SetMargins(10, 40, 10);
        
 
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_FOOTER);

        $pdf->Open();
        $pdf->AddPage();
        $pdf->SetFont('Courier','',8);

        $view = \View::make('asset::pdf.asset_asiento_contable',compact('assets','pdf'));
        $html = $view->render();

        
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("ReporteBienes_".date("d-m-Y").".pdf");


    }

}
