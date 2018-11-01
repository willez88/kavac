<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:country.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country.delete', ['only' => 'destroy']);
        $this->middleware('permission:country.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de los Países
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse con los registros de Países
     */
    public function index()
    {
        return response()->json(['records' => Country::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'prefix' => 'required|max:3'
        ]);


        $country = Country::create([
            'name' => $request->input('name'),
            'prefix' => $request->input('prefix')
        ]);

        return response()->json(['record' => $country, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Actualiza la información del Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Country $country)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'prefix' => 'required|max:3'
        ]);
 
        $country->name = $request->input('name');
        $country->prefix = $request->input('prefix');
        $country->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el Pais
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(['record' => $country, 'message' => 'Success'], 200);
    }
}
