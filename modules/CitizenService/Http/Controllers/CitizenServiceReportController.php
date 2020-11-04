<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;

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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::create');
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
    public function show()
    {
        return view('citizenservice::show');
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

    //    if ($request->citizen_service_request_types && !empty($request->citizen_service_request_types)) {
    //        foreach ($request->citizen_service_request_types as $citizen_service_request_type) {
    //            error_log($citizen_service_request_type['id']);
    //        }
    //    }

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
