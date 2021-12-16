<?php

namespace Modules\CitizenService\Http\Controllers;

use Modules\CitizenService\Pdf\CitizenServiceReport  as Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CodeSetting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use Modules\CitizenService\Models\CitizenServiceReport;
use Elibyy\TCPDF\TCPDF as PDF;
use App\Models\Institution;
use Carbon\Carbon;
use Log;

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
        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        $pdf = new Report();

        $object = (object) [
             'first_name' =>  $request[0]['first_name'],
             'id_number' => $request[0]['id_number'],
             'date' => $request[0]['date'],
             'email' => $request[0]['email'],
             'phone' => $request[0]['phone'],
             'institution_name' => $request[0]['institution_name'],
             'rif' => $request[0]['rif'],
             'institution_address' => $request[0]['institution_address'],
             'web' => $request[0]['web'],


                     ];
        $filename = 'citizenservice-report-' . Carbon::now() . '.pdf';


        $body = 'citizenservice::pdf.citizenservice_general';

        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => url(''),
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
                'field' => $object
            ]
        );

        $url = '/citizenservice/report/show/' . $filename;

        return response()->json(['result' => true,'redirect' =>  $url], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     */

    /**public function store(Request $request)
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
    } **/


    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show($filename)
    {
        $file = storage_path() . '/reports/' . $filename ?? 'citizenservice-report-' . Carbon::now() . '.pdf';
    
        return response()->download($file, $filename, [], 'inline');
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
        )->with([
            'citizenServiceRequestType'
        ])->get();

        return response()->json(['records' => $citizenservice], 200);
    }

    public function searchDate(Request $request)
    {

        $citizenservice = CitizenServiceRequest::SearchDate(
            $request->date,
            $request->citizen_service_request_types,
            $request->citizen_service_states
        )->with([
            'citizenServiceRequestType'
        ])->get();

        return response()->json(['records' => $citizenservice], 200);
    }
}
