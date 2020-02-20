<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CitizenServiceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('citizenservice::reports.create');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_search' => ['required']
        ]);

        $report = AssetReport::create([
            'type_search' => $request->input('type_search'),

            'date' => $request->input('date'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
