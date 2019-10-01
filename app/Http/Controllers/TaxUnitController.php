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
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
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
        $rules = [
            'value' => ['required'],
            'start_date' => ['required', 'date'],
        ];
        if (!is_null($request->end_date)) {
            $rules['end_date'] = ['date'];
        }
        $this->validate($request, $rules);

        $taxUnit = TaxUnit::create([
            'value' => $request->value,
            'start_date' => $request->start_date,
            'end_date' => ($request->end_date!==null)?$request->end_date:null,
            'active' => $request->active
        ]);

        return response()->json(['record' => $taxUnit, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaxUnit  $taxUnit
     * @return \Illuminate\Http\Response
     */
    public function show(TaxUnit $taxUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaxUnit  $taxUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxUnit $taxUnit)
    {
        //
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
        $this->validate($request, [
            'value' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['date']
        ]);

        $taxUnit->value = $request->value;
        $taxUnit->start_date = $request->start_date;
        $taxUnit->end_date = ($request->end_date!==null)?$request->end_date:null;
        $taxUnit->active = ($request->active);
        $taxUnit->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
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
