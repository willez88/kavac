<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceBankAccount;

class FinanceBankAccountController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => FinanceBankAccount::orderBy('ccc_number')->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ccc_number' => 'required|max:20|unique:finance_bank_accounts,ccc_number',
            'description' => 'required',
            'opened_at' => 'required|date',
            'finance_banking_agency_id' => 'required',
            'finance_account_type_id' => 'required'
        ]);

        $financeBankAccount = FinanceBankAccount::create([
            'ccc_number' => $request->ccc_number,
            'description' => $request->description,
            'opened_at' => $requestopened_at,
            'finance_banking_agency_id' => $request->finance_banking_agency_id,
            'finance_account_type_id' => $request->finance_account_type_id
        ]);

        return response()->json(['record' => $financeBankAccount, 'message' => 'Success'], 200);
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
    public function update(Request $request, $id)
    {
        $bankAccount = FinanceBankAccount::find($id);

        $this->validate($request, [
            'ccc_number' => 'required|max:20|unique:finance_bank_accounts,ccc_number,' . $bankAccount->ccc_number,
            'description' => 'required',
            'opened_at' => 'required|date',
            'finance_banking_agency_id' => 'required',
            'finance_account_type_id' => 'required'
        ]);
 
        $bankAccount->ccc_number = $request->ccc_number;
        $bankAccount->description = $request->description;
        $bankAccount->opened_at = $request->opened_at;
        $bankAccount->finance_banking_agency_id = $request->finance_banking_agency_id;
        $bankAccount->finance_account_type_id = $request->finance_account_type_id;
        $bankAccount->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $financeBankAccount = FinanceBankAccount::find($id);
        $financeBankAccount->delete();
        return response()->json(['record' => $financeBankAccount, 'message' => 'Success'], 200);
    }
}
