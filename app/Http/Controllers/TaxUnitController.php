<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\TaxUnit;
use Illuminate\Http\Request;

/**
 * @class TaxUnitController
 * @brief Gestiona información de Unidades Tributarias (U.T.)
 *
 * Controlador para gestionar Unidades Tributarias (U.T.)
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class TaxUnitController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:tax.unit.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tax.unit.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tax.unit.delete', ['only' => 'destroy']);
        $this->middleware('permission:tax.unit.list', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => TaxUnit::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric'],
            'start_date' => ['required', 'date']
        ];
        if (!is_null($request->end_date)) {
            $rules['end_date'] = ['date', 'after:start_date'];
        }
        $this->validate($request, $rules, [
            'value.required' => 'El campo valor es requerido',
            'value.numeric' => 'El campo valor debe ser numérico',
            'end_date.after' => 'La fecha final debe ser mayor a la fecha inicial'
        ]);

        $taxUnit = TaxUnit::create([
            'value' => $request->value,
            'start_date' => $request->start_date,
            'end_date' => ($request->end_date!==null)?$request->end_date:null,
            'active' => $request->active
        ]);

        return response()->json(['record' => $taxUnit, 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxUnit  $taxUnit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, TaxUnit $taxUnit)
    {
        $rules = [
            'value' => ['required', 'numeric'],
            'start_date' => ['required', 'date']
        ];
        if (!is_null($request->end_date)) {
            $rules['end_date'] = ['date', 'after:start_date'];
        }
        $this->validate($request, $rules, [
            'value.required' => 'El campo valor es requerido',
            'value.numeric' => 'El campo valor debe ser numérico',
            'end_date.after' => 'La fecha final debe ser mayor a la fecha inicial'
        ]);

        $taxUnit->value = $request->value;
        $taxUnit->start_date = $request->start_date;
        $taxUnit->end_date = ($request->end_date!==null)?$request->end_date:null;
        $taxUnit->active = ($request->active);
        $taxUnit->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaxUnit  $taxUnit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TaxUnit $taxUnit)
    {
        $taxUnit->delete();
        return response()->json(['record' => $taxUnit, 'message' => 'Success'], 200);
    }
}
