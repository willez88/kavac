<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetRequiredItem;
use Modules\Asset\Rules\Setting\AssetSpecificCategoryUnique;

/**
 * @class      AssetSpecificCategoryController
 * @brief      Controlador de Categorias Especificas de Bienes
 *
 * Clase que gestiona las Categorias Especificas de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @author     Yennifer Ramirez <yramirez@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetSpecificCategoryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.setting.specific');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'          => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100'],
            'code'          => ['required', 'max:10'],
            'asset_subcategory_id' => ['required']


        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo categoría específica es obligatorio.',
            'name.max'          => 'El campo categoría específica no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo categoría específica no debe permitir números ni símbolos.',
            'code.required'     => 'El campo código de la categoría específica es obligatorio.',
            'code.max'          => 'El campo código de la categoría específica no debe contener más de 10 caracteres.',
            'asset_subcategory_id.required' => 'El campo subcategoría es obligatorio.'


           ];
    }
    use ValidatesRequests;
    /**
     * Muestra un listado de las Subcategorias de una categoria de Bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
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
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function create()
    {
    }

    /**
     * Valida y Registra un nueva Categoria Especifica
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
            ['id' => [new AssetSpecificCategoryUnique($request->input('asset_subcategory_id'), $request->input('code'))
            ]],
            $validateRules
        );

        $this->validate($request, $this->validateRules, $this->messages);


        /**
         * Objeto asociado al modelo AssetSpecificCategory
         *
         * @var Object $specific_category
         */
        $specific_category = AssetSpecificCategory::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'asset_subcategory_id' => $request->input('asset_subcategory_id'),
        ]);

        return response()->json(['record' => $specific_category, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la Categoria Especifica de un Bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request                       $request              Datos de la petición
     * @param     \Modules\Asset\Models\AssetSpecificCategory    $specific_category    Datos de la categoria especifica
     * @return    \Illuminate\Http\JsonResponse                  Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetSpecificCategory $specific_category)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_merge(
            ['id' => [new AssetSpecificCategoryUnique($request->input('asset_subcategory_id'), $request->input('code'))
            ]],
            $validateRules
        );
        
        $this->validate($request, $this->validateRules, $this->messages);

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
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          Identificador único de la categoría específica a eliminar
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        $specific_category = AssetSpecificCategory::find($id);
        $specific_category->delete();
        return response()->json(['record' => $specific_category, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de las categorias específicas de bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer    $subcategory_id    Identificador único de la sub-categoría
     * @return    Array      Arreglo con los registros a mostrar
     */
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

    /**
     * Obtiene el listado de los requerimientos de las categorias específicas de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer    $id    Identificador único de la categoría específica
     * @return    Array      Arreglo con los registros a mostrar
     */
    public function getRequired($id)
    {
        $required = AssetRequiredItem::where('asset_specific_category_id', $id)->first();
        if (is_null($required)) {
            $required = [
                'serial' => false,
                'marca' => false,
                'model' => false,
                'address' => false
            ];
        }
        return response()->json(['record' => $required], 200);
    }
}
