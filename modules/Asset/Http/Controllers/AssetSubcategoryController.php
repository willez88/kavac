<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;


/**
 * @class AssetSubcategoryController
 * @brief Controlador de Subcategorias de Bienes
 * 
 * Clase que gestiona las Subcategorias de bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetSubcategoryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.subcategory');
    }
    use ValidatesRequests;
    /**
     * Muestra un listado de las Subcategorias de una categoria de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => AssetSubcategory::with('category')->get()], 200);
    }

    /**
     * Muestra el formulario para crear un nueva Subcategoria
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        
    }

    /**
     * Valida y Registra un nueva Subcategoria
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
            'asset_category_id' => 'required'
        ]);


        $subcategory = new AssetSubcategory;

        $subcategory->name = $request->input('name');
        $subcategory->code = $request->input('code');
        $subcategory->asset_category_id = $request->asset_category_id;

        $subcategory->save();

        return response()->json(['record' => $subcategory, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de la Subcategoria de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetSubcategory  $subcategory (Datos de la subcategoria)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetSubcategory $subcategory)
    {
        
    }

    /**
     * Muestra el formulario para actualizar información de la Subcategoria de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetSubcategory  $subcategory (Datos de la subcategoria)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit(AssetSubcategory $subcategory)
    {
        
    }

    /**
     * Actualiza la información de la Subcategoria de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetSubcategory  $subcategory (Datos de la subcategoria)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request,AssetSubcategory $subcategory)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_category_id' => 'required'
        ]);
 
        $subcategory->name = $request->input('name');
        $subcategory->code = $request->input('code');
        $subcategory->asset_category_id = $request->asset_category_id;

        $subcategory->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina la Subcategoria de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetSubcategory  $subcategory (Datos de la subcategoria)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetSubcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['record' => $subcategory, 'message' => 'Success'], 200);
    }

    public function getSubcategories($category_id){
        if(is_null($category_id))
            return template_choices('Modules\Asset\Models\AssetSubcategory','name','',true);
        $asset_category = AssetCategory::find($category_id);
        return ($asset_category)?template_choices('Modules\Asset\Models\AssetSubcategory','name',['asset_category_id' => $asset_category->id],true):[];
    }
}
