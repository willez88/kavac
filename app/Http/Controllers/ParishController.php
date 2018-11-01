<?php

namespace App\Http\Controllers;

use App\Models\Parish;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:parish.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:parish.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:parish.delete', ['only' => 'destroy']);
        $this->middleware('permission:parish.list', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Parish::with('municipality')->get()], 200);
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
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'municipality_id' => 'required'
        ]);


        $parish = Parish::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'municipality_id' => $request->input('municipality_id')
        ]);

        return response()->json(['record' => $parish, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function show(Parish $parish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function edit(Parish $parish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parish  $parish
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Parish $parish)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'municipality_id' => 'required'
        ]);
 
        $parish->name = $request->input('name');
        $parish->code = $request->input('code');
        $parish->municipality_id = $request->input('municipality_id');
        $parish->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parish  $parish
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Parish $parish)
    {
        $parish->delete();
        return response()->json(['record' => $parish, 'message' => 'Success'], 200);
    }
}
