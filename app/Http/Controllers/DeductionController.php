<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Deduction::with(['accountingAccount'])->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'formula' => ['required']
        ]);

        $request->active = (!is_null($request->active) && $request->active !== false);
        $deduction = Deduction::create($request->all());

        return response()->json(['record' => $deduction, 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Deduction $deduction)
    {
        $this->validate($request, [
            'name' => ['required'],
            'formula' => ['required']
        ]);

        $deduction->name = $request->name;
        $deduction->description = $request->description ?? null;
        $deduction->accounting_account_id = $request->accounting_account_id ?? null;
        $deduction->formula = $request->formula;
        $deduction->active = (!is_null($request->active) && $request->active !== false);
        $deduction->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Deduction $deduction)
    {
        $deduction->delete();
        return response()->json(['record' => $deduction, 'message' => 'Success'], 200);
    }
}
