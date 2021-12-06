<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetType;
use Illuminate\Validation\Rule;

/**
 * @class      AssetTypeController
 * @brief      Controlador de tipos de bienes institucionales
 *
 * Clase que gestiona los tipos de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetTypeController extends Controller
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
        $this->middleware('permission:asset.setting.type');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'     => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100',
                            Rule::unique('asset_types')],


        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo tipo de bien es obligatorio.',
            'name.max'          => 'El campo tipo de bien no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo tipo de bien no debe permitir números ni símbolos.',
            'name.unique'       => 'El campo tipo de bien ya ha sido registrado.'

           ];
    }

    /**
     * Muestra un listado de los tipos de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo de bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);


        /**
         * Objeto asociado al modelo AssetType
         *
         * @var Object $type
         */
        $type = AssetType::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request           $request    Datos de la petición
     * @param     \Modules\Asset\Models\AssetType    $type       Datos del tipo de bien
     * @return    \Illuminate\Http\JsonResponse      Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetType $type)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100',
                            Rule::unique('asset_types')->ignore($type->id)]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $type->name = $request->input('name');
        $type->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetType    $type    Datos del tipo de bien
     * @return    \Illuminate\Http\JsonResponse      Objeto con los registros a mostrar
     */
    public function destroy(AssetType $type)
    {
        $type->delete();
        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de tipos de bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Arreglo con los registros a mostrar
     */
    public function getTypes()
    {
        return template_choices('Modules\Asset\Models\AssetType', 'name', '', true);
    }
}
