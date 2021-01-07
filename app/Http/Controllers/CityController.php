<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

/**
 * @class CityController
 * @brief Controlador de Ciudades
 *
 * Clase que gestiona las Ciudades
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/' target="_blank">
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CityController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:city.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city.delete', ['only' => 'destroy']);
        $this->middleware('permission:city.list', ['only' => 'index']);
    }

    /**
     * Muestra un listado de Ciudades
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => City::with('estate')->get()], 200);
    }

    /**
     * Registra una nueva Ciudad
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param \Illuminate\Http\Request $request Datos de la petición
     * @return \Illuminate\Http\JsonResponse con el resultado de la petición
     */
    public function store(Request $request)
    {
        if (!restore_record(City::class, ['name' => $request->name, 'estate_id' => $request->estate_id])) {
            $this->validate($request, [
                'name' => ['required', 'max:100'],
                'estate_id' => ['required']
            ]);
        }

        /** @var City Objeto con información de la ciudad registrada */
        $city = City::create([
            'name' => $request->name,
            'estate_id' => $request->estate_id
        ]);

        return response()->json(['record' => $city, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de una Ciudad
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param \Illuminate\Http\Request $request Datos de la petición
     * @param \App\Models\City $city Datos de la Ciudad
     * @return \Illuminate\Http\JsonResponse con el resultado de la petición
     */
    public function update(Request $request, City $city)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'estate_id' => ['required']
        ]);

        $city->name = $request->name;
        $city->estate_id = $request->estate_id;
        $city->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina una Ciudad específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param \App\Models\City $city Datos de la Ciudad
     * @return \Illuminate\Http\JsonResponse con el resultado de la petición
     */
    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['record' => $city, 'message' => 'Success'], 200);
    }
}
