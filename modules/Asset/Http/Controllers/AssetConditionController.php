<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetCondition;

/**
 * @class      AssetConditionController
 * @brief      Controlador de la condición física de los bienes institucionales
 *
 * Clase que gestiona la condición física de los bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetConditionController extends Controller
{
    use ValidatesRequests;
    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;
    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:asset.setting.condition');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'     => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100'],

        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo condición física es obligatorio.',
            'name.max'          => 'El campo condición física no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo condición física no debe permitir números ni símbolos.'
           ];
    }

    /**
     * Muestra un listado de las condiciones físicas de los bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetCondition::all()], 200);
    }

    /**
     * Valida y registra una nueva condición física
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
         * Objeto asociado al modelo AssetCondition
         *
         * @var Object $condition
         */
        $condition = AssetCondition::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $condition, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la condición física de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request                $request      Datos de la petición
     * @param     \Modules\Asset\Models\AssetCondition    $condition    Datos de la condición física
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetCondition $condition)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        $condition->name = $request->input('name');
        $condition->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la condición física de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetCondition    $condition    Datos de la condición física
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function destroy(AssetCondition $condition)
    {
        $condition->delete();
        return response()->json(['record' => $condition, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de las condiciones físicas de los bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Arreglo con los registros a mostrar
     */
    public function getConditions()
    {
        return template_choices('Modules\Asset\Models\AssetCondition', 'name', '', true);
    }
}
