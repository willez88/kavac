<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\TechnicalSupport\Models\TechnicalSupportRepair;

class TechnicalSupportDiagnosticController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
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
     * @return Renderable
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('technicalsupport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit($id)
    {
        $technicalSupportRepair = TechnicalSupportRepair::find($id);
        return view('technicalsupport::diagnostics.create', compact('technicalSupportRepair'));
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

    public function createDiagnostic($id)
    {
        dd($id);
    }
}
