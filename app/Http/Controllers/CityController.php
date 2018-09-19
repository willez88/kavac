<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

/**
 * @class CityController
 * @brief Controlador de Ciudades
 * 
 * Clase que gestiona las Ciudades
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CityController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return JSON con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => City::with('estate')->get()], 200);
    }

    /**
     * Muestra el formulario para crear una nueva Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con los datos a mostrar en el formulario
     */
    public function create()
    {
        //
    }

    /**
     * Registra una nueva Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param[in] $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @return JSON con el resultado de la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'estate_id' => 'required'
        ]);

        $city = City::create([
            'name' => $request->input('name'),
            'estate_id' => $request->input('estate_id')
        ]);

        return response()->json(['record' => $city, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de una Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param[in] $city [<b>App::Models::City</b>] Datos de la Ciudad
     * @return Objeto con los datos a mostrar
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Muestra el formulario con los datos a modificar de una Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param[in] $city [<b>App::Models::City</b>] Datos de la Ciudad
     * @return Objeto con los datos a mostrar en el formulario de edición
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Muestra los datos de una Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param[in] $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @param[in] $city [<b>App::Models::City</b>] Datos de la Ciudad
     * @return JSON con el resultado de la petición
     */
    public function update(Request $request, City $city)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'estate_id' => 'required'
        ]);
 
        $city->name = $request->input('name');
        $city->estate_id = $request->input('estate_id');
        $city->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina una Ciudad específica
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param[in] $city [<b>App::Models::City</b>] Datos de la Ciudad
     * @return JSON con el resultado de la petición
     */
    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['record' => $city, 'message' => 'Success'], 200);
    }
}
