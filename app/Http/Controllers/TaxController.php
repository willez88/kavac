<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\HistoryTax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        /*$this->middleware('permission:tax.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tax.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tax.delete', ['only' => 'destroy']);
        $this->middleware('permission:tax.list', ['only' => 'index']);*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Tax::with('histories')->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|max:60',
            'description' => 'required',
            'operation_date' => 'required|date',
            'percentage' => 'required'
        ]);


        $tax = Tax::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'affect_tax' => ($request->input('affect_tax')!==null),
            'active' => ($request->input('active')!==null),
        ]);

        HistoryTax::create([
            'operation_date' => $request->input('operation_date'),
            'percentage' => $request->input('percentage'),
            'tax_id' => $tax->id
        ]);

        return response()->json(['record' => $tax, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Tax $tax)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'description' => 'required',
            'operation_date' => 'required|date',
            'percentage' => 'required'
        ]);

        $tax->name = $request->input('name');
        $tax->description = $request->input('description');
        $tax->operation_date = $request->input('operation_date');
        $tax->percentage = $request->input('percentage');
        $tax->affect_tax = ($request->input('affect_tax'));
        $tax->active = ($request->input('active'));
        $tax->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();
        return response()->json(['record' => $tax, 'message' => 'Success'], 200);
    }
}
