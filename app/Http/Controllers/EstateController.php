<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;

/**
 * @class EstateController
 * @brief Gestiona información de Estados
 *
 * Controlador para gestionar Estados
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class EstateController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:estate.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:estate.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estate.delete', ['only' => 'destroy']);
        $this->middleware('permission:estate.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de los Estados
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Estate::with('country')->get()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de Estado
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo Estado
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
            'country_id' => ['required']
        ]);


        $estate = Estate::create([
            'name' => $request->name,
            'code' => $request->code,
            'country_id' => $request->country_id
        ]);

        return response()->json(['record' => $estate, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del Estado
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function show(Estate $estate)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un Estado
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estate $estate)
    {
        //
    }

    /**
     * Actualiza la información del Estado
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Estate $estate)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'country_id' => ['required']
        ]);

        $estate->name = $request->name;
        $estate->code = $request->code;
        $estate->country_id = $request->country_id;
        $estate->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el Estado
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Estate $estate)
    {
        $estate->delete();
        return response()->json(['record' => $estate, 'message' => 'Success'], 200);
    }
}
