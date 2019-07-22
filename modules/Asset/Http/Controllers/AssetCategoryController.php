<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetType;

/**
 * @class AssetCategoryController
 * @brief Controlador de categorias de bienes institucionales
 * 
 * Clase que gestiona las categorias de bienes institucionales
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetCategoryController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.category');
    }

    /**
     * Muestra un listado de las categorias de un tipo de bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetCategory::with('asset_type')->get()], 200);
    }

    /**
     * Valida y registra un nueva categoria general
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_type_id' => 'required'
        ]);


        $category = AssetCategory::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'asset_type_id' => $request->asset_type_id,
        ]);

        return response()->json(['record' => $category, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la categoria general
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request               Datos de la petición
     * @param  \Modules\Asset\Models\AssetCategory  $category   Datos de la categoria
     * @return \Illuminate\Http\JsonResponse                    Objeto con los registros a mostrar
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
        $category->asset_type_id = $request->asset_type_id;
        $category->save();
 
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la categoria general
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetCategory  $category   Datos de la categoria
     * @return \Illuminate\Http\JsonResponse                    Objeto con los registros a mostrar
     */
    public function destroy(AssetCategory $category)
    {
        $category->delete();
        return response()->json(['record' => $category, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de las categorias generales de bienes institucionales a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer]  $type_id   Identificador único del tipo de bien
     * @return [Array] Arreglo con los registros a mostrar
     */
    public function getCategories($type_id = null)
    {
        if(is_null($type_id))
            return template_choices('Modules\Asset\Models\AssetCategory', 'name', '', true);
        $asset_type = AssetType::find($type_id);
        return ($asset_type)?template_choices('Modules\Asset\Models\AssetCategory', 'name', ['asset_type_id' => $asset_type->id], true):[];
    }
}
