<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetRequiredItem;

/**
 * @class AssetSpecificCategoryController
 * @brief Controlador de Categorias Especificas de Bienes
 *
 * Clase que gestiona las Categorias Especificas de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetSpecificCategoryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.specific');
    }
    use ValidatesRequests;
    /**
     * Muestra un listado de las Subcategorias de una categoria de Bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => AssetSpecificCategory::with(
            ['assetSubcategory' =>

            function ($query) {
                $query->with(['assetCategory' => function ($query) {
                    $query->with('assetType');
                }]);
            }]
        )->get()], 200);
    }

    /**
     * Muestra el formulario para crear un nueva Categoria Especifica
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
    }

    /**
     * Valida y Registra un nueva Categoria Especifica
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_subcategory_id' => 'required',
        ]);


        $specific_category = AssetSpecificCategory::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'asset_subcategory_id' => $request->input('asset_subcategory_id'),
        ]);

        return response()->json(['record' => $specific_category, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de la Categoria Especifica de un Bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetSpecificCategory  $specific_category (Datos de la categoria especifica)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetSpecificCategory $specific_category)
    {
    }

    /**
     * Muestra el formulario para actualizar información de la Categoria Especifica de un Bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetSpecificCategory  $specific_category (Datos de la categoria especifica)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit(AssetSpecificCategory $specific_category)
    {
    }

    /**
     * Actualiza la información de la Categoria Especifica de un Bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetSpecificCategory  $specific_category (Datos de la categoria especifica)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, AssetSpecificCategory $specific_category)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'code' => 'required|max:10',
            'asset_subcategory_id' => 'required',
        ]);
        $specific_category = AssetSpecificCategory::find($request->id);
 
        $specific_category->name = $request->input('name');
        $specific_category->code = $request->input('code');
        $specific_category->asset_subcategory_id = $request->input('asset_subcategory_id');

        $specific_category->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina la Categoria Especifica de un Bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetSpecificCategory  $specific_category (Datos de la categoria especifica)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $specific_category = AssetSpecificCategory::find($id);
        $specific_category->delete();
        return response()->json(['record' => $specific_category, 'message' => 'Success'], 200);
    }

    public function getSpecificCategories($subcategory_id = null)
    {
        if (is_null($subcategory_id)) {
            return template_choices('Modules\Asset\Models\AssetSpecificCategory', 'name', '', true);
        }
        $asset_subcategory = AssetSubcategory::find($subcategory_id);
        return ($asset_subcategory)?template_choices(
            'Modules\Asset\Models\AssetSpecificCategory',
            'name',
            ['asset_subcategory_id' => $asset_subcategory->id],
            true
        ):[];
    }

    public function getRequired($id)
    {
        $required = AssetRequiredItem::where('asset_specific_category_id', $id)->first();
        return response()->json(['record' => $required], 200);
    }
}
