<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetCategory;


/**
 * @class AssetCategoryController
 * @brief Controlador de Categorias de Bienes
 * 
 * Clase que gestiona las Categorias de bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetCategoryController extends Controller
{
    use ValidatesRequests;
    /**
     * Muestra un listado de las Categorias de un Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => AssetCategory::with('type')->get()], 200);
    }

    /**
     * Muestra el formulario para crear un nueva Categoria General
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        
    }

    /**
     * Valida y Registra un nueva Categoria General
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_type_id' => 'required'
        ]);


        $category = new AssetCategory;
        $category->name = $request->input('name');
        $category->code = $request->input('code');
        $category->asset_type_id = $request->type_id;

        return response()->json(['record' => $category, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de la Categoria General de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetCategory  $category (Datos de la categoria)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetCategory $category)
    {
        
    }

    /**
     * Muestra el formulario para actualizar información de la Categoria General de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetCategory  $category (Datos de la categoria)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    
    public function edit(AssetCategory $category)
    {
        
    }

    /**
     * Actualiza la información de la Categoria General
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetCategory  $category (Datos de la categoria)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, AssetCategory $category)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_type_id' => 'required'
        ]);
 
        
        $category->name = $request->input('name');
        $category->code = $request->input('code');
        $category->asset_type_id = $request->type_id;


        $category->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina la Categoria General
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetCategory  $category (Datos de la categoria)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetCategory $category)
    {
        $category->delete();
        return response()->json(['record' => $category, 'message' => 'Success'], 200);
    }
}
