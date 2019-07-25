<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CodeSetting;
use Modules\Asset\Pdf\Pdf;

use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\Asset;

use Modules\Asset\Models\AssetReport;
use App\Models\Institution;
use App\Models\Setting;

class AssetReportController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.report.create', ['only' => 'create']);
    }
    
    /**
     * Muestra un listado de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('asset::reports.create');
    }

    /**
     * Valida y registra un nuevo reporte de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_report' => 'required'
        ]);


        $codeSetting = CodeSetting::where('table', 'asset_reports')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('asset.setting.index')], 200);
        }

        if ($request->type_report == 'general') {
            if ($request->type_search == 'date') {
                $report = AssetReport::where('type_report', $request->type_report)
                                     ->where('type_search', $request->type_search)
                                     ->where('start_date', $request->start_date)
                                     ->where('end_date', $request->end_date)->first();
            }
            else if ($request->type_search == 'mes') {
                $report = AssetReport::where('type_report', $request->type_report)
                                     ->where('type_search', $request->type_search)
                                     ->where('mes', $request->mes_id)
                                     ->where('year', $request->year)->first();
            }
            else
                $report = AssetReport::where('type_report', $request->type_report)
                                     ->where('type_search', $request->type_search)
                                     ->where('start_date', null)
                                     ->where('end_date', null)
                                     ->where('mes', null)
                                     ->where('year', null)->first();

        }
        else if ($request->type_report == 'clasification') {
            $report = AssetReport::where('type_report', $request->type_report)
                                     ->where('asset_type_id', $request->asset_type_id)
                                     ->where('asset_category_id', $request->asset_category_id)
                                     ->where('asset_subcategory_id', $request->asset_subcategory_id)
                                     ->where('asset_specific_category_id', $request->asset_specific_category_id)->first();

        }
        else if ($request->type_report == 'dependence') {
            $report = AssetReport::where('type_report', $request->type_report)
                                     ->where('institution_id', $request->institution_id)
                                     ->where('department_id', $request->department_id)->first();
            
        }

        if (is_null($report)) {

            $cod = generate_registration_code($codeSetting->format_prefix, strlen($codeSetting->format_digits), (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'), $codeSetting->model, $codeSetting->field);
            
            return response()->json(['result' => true, 'redirect' => $cod], 200);

            $report = AssetReport::create([
                'code' => $code,
                'type_report' => $request->input('type_report'),
                'type_search' => $request->input('type_search'),

                'asset_type_id' => $request->input('asset_type_id'),
                'asset_category_id' => $request->input('asset_category_id'),
                'asset_subcategory_id' => $request->input('asset_subcategory_id'),
                'asset_specific_category_id' => $request->input('asset_specific_category_id'),

                'institution_id' => $request->input('institution_id'),
                'department_id' => $request->input('department_id'),
                'mes' => $request->input('mes_id'),
                'year' => $request->input('year'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
        }

        return response()->json(['result' => true, 'redirect' => 'reports/show/'.$report->code], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($code_report)
    {
        $report = AssetReport::where('code', $code_report)->first();

        if ($report->type_report == 'general') {
            $assets = Asset::dateclasification($report->start_date,$report->end_date,$report->mes,$report->year)->get();

        $setting = Setting::all()->first();        

        $pdf = new Pdf('L','mm','Letter');
        
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

        $pdf->Output($report->code.".pdf");
        }
        else if ($report->type_report == 'clasification') {
            if ($report->type_search != '') {
                $assets = Asset::dateclasification($report->start_date,$request->end_date,$request->mes_id,$request->year_id)->get();
            }   
            else {
                $assets = Asset::all();
            }
            
            $setting = Setting::all()->first();        
            $pdf = new Pdf('L','mm','Letter');

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
            
            $pdf->Output($report->code.".pdf");
        }
    }
}
