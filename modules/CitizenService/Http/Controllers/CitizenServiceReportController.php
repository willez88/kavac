<?php

namespace Modules\CitizenService\Http\Controllers;

use Modules\CitizenService\Pdf\CitizenServiceReport as ReportRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CodeSetting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use Modules\CitizenService\Models\CitizenServiceReport;
use App\Models\Institution;
use Carbon\Carbon;

class CitizenServiceReportController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('citizenservice::reports.create');
    }
    public function request()
    {
        return view('citizenservice::reports.citizenservice-report-request');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        /** Para el PDF**/
        $institution = Institution::where('default', true)
            ->where('active', true)->first();
        $pdf = new ReportRepository();
        $filename = 'citizenservice-report-' . Carbon::now() . '.pdf';

        $codeSetting = CodeSetting::where('table', 'citizen_service_reports')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
            'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
            'text' => 'Debe configurar previamente el formato para el código a generar'
            ]);
            return response()->json(['result' => false, 'redirect' => route('citizenservice.setting.index')], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        $report = CitizenServiceReport::create([
            'type_search' => $request->input('type_search'),

            'date' => $request->input('date'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        /*
         *  Definicion de las caracteristicas generales de la página
         */
        $body = 'citizenservice::pdf.citizenservice-report-request';

        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => 'www.google.com',
                'orientation' => 'L',
                'filename'    => $filename
            ]
        );

        $pdf->setHeader("Reporte de solicitudes");
        $pdf->setFooter();
        $pdf->setBody(
            $body,
            true,
            [
                'pdf'    => $pdf,
                'fields' => $fields
            ]
        );
        $url = '/citizenservice/report/show/' . $filename;
        return response()->json(['result' => true, $redirect => $url], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'type_search' => ['required']
        ]);

        $report = CitizenServiceReport::create([
            'type_search' => $request->input('type_search'),

            'date' => $request->input('date'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);
    }


    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show($code)
    {
        $report = CitizenServiceReport::where('code', $code)->first();
        $pdf = new ReportRepository();
        $pdf->show($report->filename);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy()
    {
    }

    public function searchPeriod(Request $request)
    {

        $citizenservice = CitizenServiceRequest::SearchPeriod(
            $request->start_date,
            $request->end_date,
            $request->citizen_service_request_types,
            $request->citizen_service_states
        )->get();

        return response()->json(['records' => $citizenservice], 200);
    }

    public function searchDate(Request $request)
    {

        $citizenservice = CitizenServiceRequest::SearchDate(
            $request->date,
            $request->citizen_service_request_types,
            $request->citizen_service_states
        )->get();

        return response()->json(['records' => $citizenservice], 200);
    }
}
