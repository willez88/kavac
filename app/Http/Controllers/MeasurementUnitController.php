<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use Illuminate\Http\Request;

class MeasurementUnitController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:measurement.units.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:measurement.units.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:measurement.units.delete', ['only' => 'destroy']);
        $this->middleware('permission:measurement.units.list', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => MeasurementUnit::all()], 200);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:measurement_units,name'],
            'description' => ['required'],
            'acronym' => ['required', 'max:6', 'unique:measurement_units,acronym']
        ]);


        $measurementUnit = MeasurementUnit::create([
            'name' => $request->name,
            'description' => $request->description,
            'acronym' => $request->acronym
        ]);

        return response()->json(['record' => $measurementUnit, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function show(MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeasurementUnit $measurementUnit)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:measurement_units,name,' . $measurementUnit->id],
            'description' => ['required'],
            'acronym' => ['required', 'max:6', 'unique:measurement_units,acronym,' . $measurementUnit->id]
        ]);

        $measurementUnit->name = $request->name;
        $measurementUnit->description = $request->description;
        $measurementUnit->acronym = $request->acronym;
        $measurementUnit->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeasurementUnit $measurementUnit)
    {
        $measurementUnit->delete();
        return response()->json(['record' => $measurementUnit, 'message' => 'Success'], 200);
    }
}
