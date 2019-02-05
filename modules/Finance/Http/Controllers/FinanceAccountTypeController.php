<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Finance\Models\FinanceAccountType;

class FinanceAccountTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => FinanceAccountType::all()], 200);
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
            'name' => 'required|max:100|unique:finance_account_types,name',
        ]);

        $financeAccountType = FinanceAccountType::create([
            'name' => $request->name,
        ]);

        return response()->json(['record' => $financeAccountType, 'message' => 'Success'], 200);
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
        $financeAccountType = FinanceAccountType::find($id);
        
        $this->validate($request, [
            'name' => 'required|max:100|unique:finance_account_types,name,' . $financeAccountType->id,
        ]);
 
        $financeAccountType->name = $request->name;
        $financeAccountType->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $financeAccountType = FinanceAccountType::find($id);
        $financeAccountType->delete();
        return response()->json(['record' => $financeAccountType, 'message' => 'Success'], 200);
    }
}
