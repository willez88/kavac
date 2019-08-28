<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetType;

/**
 * @class AssetClasificationController
 * @brief Controlador del clasificador de bienes institucionales
 *
 * Clase que gestiona el clasificador de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetClasificationController extends Controller
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
        $this->middleware('permission:asset.setting.specific');
    }

    /**
     * Muestra un listado del clasificador de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetSpecificCategory::with(
            ['assetSubcategory' => function ($query) {
                $query->with(['assetCategory' => function ($query) {
                    $query->with('assetType');
                }]);
            }]
        )->get()], 200);
    }

    /**
     * Valida y registra un nuevo registro en el clasificador de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        /** Validación de los datos de la petición */
        $this->validate($request, [
            'asset_type_id' => 'required',
            'asset_category_id' => 'required',
            'asset_subcategory_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);
        if ($request->asset_type_id === '-1') {
            $this->validate($request, [
                'type.name' => 'required',
            ]);
        }
        if ($request->asset_category_id === '-1') {
            $this->validate($request, [
                'category.code' => 'required',
                'category.name' => 'required',
            ]);
        }
        if ($request->asset_subcategory_id === '-1') {
            $this->validate($request, [
                'subcategory.code' => 'required',
                'subcategory.name' => 'required',
            ]);
        }

        if ($request->asset_type_id === '-1') {
            $type = AssetType::create([
                'name' => $request->input('name'),
            ]);
        }

        if ($request->asset_category_id === '-1') {
            $category = AssetCategory::create([
                'code' => $request->input('category.code'),
                'name' => $request->input('category.name'),
                'asset_type_id' => $type->id,
            ]);
        }
        if ($request->asset_subcategory_id === '-1') {
            $subcategory = AssetSubcategory::create([
                'code' => $request->input('subcategory.code'),
                'name' => $request->input('subcategory.name'),
                'asset_category_id' => $category->id,
            ]);
        }
        $specific = AssetSpecificCategory::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'asset_subcategory_id' => ($request->asset_subcategory_id === '-1')?$subcategory->id:
                                                                                $request->asset_subcategory_id,
        ]);

        return response()->json(['records' => $specific, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del clasificador de bienes
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request                       Datos de la petición
     * @param  \Modules\Asset\Models\AssetSpecificCategory  $specific   Datos de la categoria
     * @return \Illuminate\Http\JsonResponse                            Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetSpecificCategory $specific)
    {
        $this->validate($request, [
            'asset_type_id' => 'required',
            'asset_category_id' => 'required',
            'asset_subcategory_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);
        if ($request->asset_type_id === '-1') {
            $this->validate($request, [
                'type.name' => 'required',
            ]);
        }
        if ($request->asset_category_id === '-1') {
            $this->validate($request, [
                'category.code' => 'required',
                'category.name' => 'required',
            ]);
        }
        if ($request->asset_subcategory_id === '-1') {
            $this->validate($request, [
                'subcategory.code' => 'required',
                'subcategory.name' => 'required',
            ]);
        }

        $specific = AssetSpecificCategory::find($request->id);
        
        $specific->name = $request->input('name');
        $specific->code = $request->input('code');
        $specific->asset_subcategory_id = $request->input('asset_subcategory_id');
        $specific->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un registro del clasificador de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único del registro a eliminar
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        $specific = AssetSpecificCategory::find($id);
        $specific->delete();
        return response()->json(['record' => $specific, 'message' => 'Success'], 200);
    }
}
