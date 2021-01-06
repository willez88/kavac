<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @class MunicipalityController
 * @brief Gestiona información de Municipios
 *
 * Controlador para gestionar Municipios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class MunicipalityController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:municipality.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:municipality.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:municipality.delete', ['only' => 'destroy']);
        $this->middleware('permission:municipality.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de los Municipios
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Municipality::with('estate')->get()], 200);
    }

    /**
     * Valida y registra un nuevo Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'estate_id' => ['required']
        ]);

        if ($m = Municipality::onlyTrashed()->where([
            'name' => $request->name, 'estate_id' => $request->estate_id
        ])->first()) {
            $m->restore();
        } else {
            $this->validate($request, [
                'name' => Rule::unique('municipalities')->where(function ($query) use ($request) {
                    return $query->where('estate_id', $request->estate_id)->where('name', $request->name);
                })
            ]);
        }

        $municipality = Municipality::updateOrCreate([
            'name' => $request->name,
            'estate_id' => $request->estate_id
        ], [
            'code' => $request->code
        ]);

        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Municipality $municipality)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'estate_id' => ['required']
        ]);

        $municipality->name = $request->name;
        $municipality->code = $request->code;
        $municipality->estate_id = $request->estate_id;
        $municipality->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina el Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }
}
