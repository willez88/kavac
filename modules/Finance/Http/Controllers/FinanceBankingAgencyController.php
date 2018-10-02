<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceBankingAgency;

class FinanceBankingAgencyController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => FinanceBankingAgency::with(['city', 'phones'])->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'direction' => 'required',
            'city_id' => 'required',
            'finance_bank_id' => 'required'
        ]);

        $bankingAgency = FinanceBankingAgency::create([
            'name' => $request->input('name'),
            'direction' => $request->input('direction'),
            'finance_bank_id' => $request->input('finance_bank_id'),
            'contact_person' => (!empty($request->input('contact_person')))?$request->input('contact_person'):null,
            'contact_email' => (!empty($request->input('contact_email')))?$request->input('contact_email'):null,
            'headquarters' => (!is_null($request->input('headquarters')))
        ]);

        if ($request->input('phones')) {
            // Guardar número telefónicos
        }

        return response()->json(['record' => $bankingAgency, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('finance::edit');
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
