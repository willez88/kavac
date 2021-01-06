<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

/**
 * @class CountryController
 * @brief Gestiona información de Países
 *
 * Controlador para gestionar Países
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CountryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse con los registros de Países
     */
    public function index()
    {
        return response()->json(['records' => Country::all()], 200);
    }

    /**
     * Valida y registra un nuevo Pais
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'prefix' => ['required', 'max:3']
        ]);

        if ($c = Country::onlyTrashed()->whereName($request->name)->first()) {
            $c->restore();
        } else {
            $this->validate($request, [
                'name' => ['unique:countries,name']
            ]);
        }

        $country = Country::updateOrCreate([
            'name' => $request->name
        ], [
            'prefix' => $request->prefix
        ]);

        return response()->json(['record' => $country, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del Pais
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Country $country)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:countries,name,' . $country->id],
            'prefix' => ['required', 'max:3', 'unique:countries,prefix,' . $country->id]
        ]);

        $country->name = $request->name;
        $country->prefix = $request->prefix;
        $country->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina el Pais
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(['record' => $country, 'message' => 'Success'], 200);
    }
}
