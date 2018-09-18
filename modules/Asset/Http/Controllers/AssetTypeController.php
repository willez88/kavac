<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetType;


/**
 * @class AssetTypeController
 * @brief Controlador de Tipos de Bienes
 * 
 * Clase que gestiona los tipos de bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetTypeController extends Controller
{
    use ValidatesRequests;
    /**
     * Muestra un listado de los Tipos de Bienes
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => AssetType::all()], 200);
    }

   /**
     * Muestra el formulario para crear un nuevo Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {

    }

    /**
     * Valida y Registra un nuevo Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);


        $type = AssetType::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de un Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetType  $type (Datos del Tipo de Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetType $type)
    {

    }

    /**
     * Muestra el formulario para actualizar información de un Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetType  $type (Datos del Tipo de Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    
    public function edit(AssetType $type)
    {
        
    }

    /**
     * Actualiza la información del Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetType  $type (Datos del Tipo de Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function update(Request $request, AssetType $type)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
 
        $type->name = $request->input('name');
        $type->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetType  $type (Datos del Tipo de Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetType $type)
    {
        $type->delete();
        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }
}
