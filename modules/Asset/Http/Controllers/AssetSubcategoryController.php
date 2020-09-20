<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetCategory;

/**
 * @class      AssetSubcategoryController
 * @brief      Controlador de Subcategorias de Bienes
 *
 * Clase que gestiona las Subcategorias de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetSubcategoryController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.subcategory');
    }

    /**
     * Muestra un listado de las subcategorias de una categoria general de los bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetSubcategory::with('assetCategory')->get()], 200);
    }

    /**
     * Valida y registra un nueva subcategoria
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'asset_category_id' => ['required']
        ]);


        /**
         * Objeto asociado al modelo AssetSubcategory
         *
         * @var Object $subcategory
         */
        $subcategory = AssetSubcategory::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'asset_category_id' => $request->asset_category_id,
        ]);

        return response()->json(['record' => $subcategory, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la subcategoria de un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request                  $request        Datos de la petición
     * @param     \Modules\Asset\Models\AssetSubcategory    $subcategory    Datos de la subcategoria
     * @return    \Illuminate\Http\JsonResponse             Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetSubcategory $subcategory)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'asset_category_id' => ['required']
        ]);

        $subcategory->name = $request->input('name');
        $subcategory->code = $request->input('code');
        $subcategory->asset_category_id = $request->asset_category_id;
        $subcategory->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la subcategoria de un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetSubcategory    $subcategory    Datos de la subcategoria
     * @return    \Illuminate\Http\JsonResponse             Objeto con los registros a mostrar
     */
    public function destroy(AssetSubcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['record' => $subcategory, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de subcategorias de un bien  institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetSubcategory    $subcategory    Datos de la subcategoria
     * @return    \Illuminate\Http\JsonResponse             Objeto con los registros a mostrar
     */
    public function getSubcategories($category_id = null)
    {
        if (is_null($category_id)) {
            return template_choices('Modules\Asset\Models\AssetSubcategory', 'name', '', true);
        }
        $asset_category = AssetCategory::find($category_id);
        return ($asset_category)?template_choices(
            'Modules\Asset\Models\AssetSubcategory',
            'name',
            ['asset_category_id' => $asset_category->id],
            true
        ):[];
    }
}
