<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\TechnicalSupport\Models\TechnicalSupportRepair;

class TechnicalSupportDiagnosticController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id)
    {
        $technicalSupportRepair = TechnicalSupportRepair::find($id);
        $technicalSupportRepair->state = 'En reparación';
        $technicalSupportRepair->save();
        return view('technicalsupport::diagnostics.create', compact('technicalSupportRepair'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('technicalsupport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $technicalSupportRepair = TechnicalSupportRepair::find($id);
        return view('technicalsupport::diagnostics.create', compact('technicalSupportRepair'));
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

    public function createDiagnostic($id)
    {
        dd($id);
    }
}
