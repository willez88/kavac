<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Parish;
use Illuminate\Http\Request;

/**
 * @class ParishController
 * @brief Gestiona información de Parroquias
 *
 * Controlador para gestionar Parroquias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ParishController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'municipality_id' => ['required']
        ]);


        $parish = Parish::create([
            'name' => $request->name,
            'code' => $request->code,
            'municipality_id' => $request->municipality_id
        ]);

        return response()->json(['record' => $parish, 'message' => 'Success'], 200);
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
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'municipality_id' => ['required']
        ]);

        $parish->name = $request->name;
        $parish->code = $request->code;
        $parish->municipality_id = $request->municipality_id;
        $parish->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
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
