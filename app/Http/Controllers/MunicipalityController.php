<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Municipality::with('estate')->get()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>v
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'estate_id' => 'required'
        ]);


        $municipality = Municipality::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'estate_id' => $request->input('estate_id')
        ]);

        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\Response
     */
    public function show(Municipality $municipality)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\Response
     */
    public function edit(Municipality $municipality)
    {
        //
    }

    /**
     * Actualiza la información del Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Municipality $municipality)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'estate_id' => 'required'
        ]);
 
        $municipality->name = $request->input('name');
        $municipality->code = $request->input('code');
        $municipality->estate_id = $request->input('estate_id');
        $municipality->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el Municipio
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Municipality  $municipality
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }
}
