<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Rules\Setting\AssetSubcategoryUnique;

/**
 * @class      AssetSubcategoryController
 * @brief      Controlador de Subcategorias de Bienes
 *
 * Clase que gestiona las Subcategorias de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetSubcategoryController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.subcategory');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'          => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100'],
            'code'          => ['required', 'max:10'],
            'asset_category_id' => ['required']


        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo subcategoría es obligatorio.',
            'name.max'          => 'El campo subcategoría no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo subcategoría no debe permitir números ni símbolos.',
            'code.required'     => 'El campo código de la subcategoría es obligatorio.',
            'code.max'          => 'El campo código de la subcategoría no debe contener más de 10 caracteres.',
            'asset_category_id.required' => 'El campo categoría general es obligatorio.'


           ];
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
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_merge(
            ['id' => [new AssetSubcategoryUnique($request->input('asset_category_id'), $request->input('code'))]],
            $validateRules
        );

        $this->validate($request, $this->validateRules, $this->messages);


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
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request                  $request        Datos de la petición
     * @param     \Modules\Asset\Models\AssetSubcategory    $subcategory    Datos de la subcategoria
     * @return    \Illuminate\Http\JsonResponse             Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetSubcategory $subcategory)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_merge(
            ['id' => [new AssetSubcategoryUnique($request->input('asset_category_id'), $request->input('code'))]],
            $validateRules
        );

        $this->validate($request, $this->validateRules, $this->messages);

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
