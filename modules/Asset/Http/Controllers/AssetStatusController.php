<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetStatus;
use Illuminate\Validation\Rule;

/**
 * @class      AssetStatusController
 * @brief      Controlador de los estatus de uso de bienes institucionales
 *
 * Clase que gestiona los estatus de uso de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetStatusController extends Controller
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
        //$this->middleware('permission:asset.setting.status');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'     => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100', Rule::unique('asset_status')],

        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo estatus de uso es obligatorio.',
            'name.max'          => 'El campo estatus de uso no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo estatus de uso no debe permitir números ni símbolos.',
            'name.unique'       => 'El campo estatus de uso ya ha sido registrado'
           ];
    }

    /**
     * Muestra un listado de los estatus de uso de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetStatus::all()], 200);
    }

    /**
     * Valida y registra un nuevo estatus de uso de un bien
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
         * Objeto asociado al modelo AssetStatus
         *
         * @var Object $status
         */
        $status = AssetStatus::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $status, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del estatus de uso de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request             $request    Datos de la petición
     * @param     \Modules\Asset\Models\AssetStatus    $status     Datos del status de uso de un bien
     * @return    \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */

    public function update(Request $request, AssetStatus $status)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100',
                            Rule::unique('asset_status')->ignore($status->id)]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $status->name = $request->input('name');
        $status->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el estatus de uso de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetStatus    $status    Datos del estatus de uso de un bien
     * @return    \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function destroy(AssetStatus $status)
    {
        $status->delete();
        return response()->json(['record' => $status, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de los estatus de uso de los bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Arreglo con los registros a mostrar
     */
    public function getStatus()
    {
        return template_choices('Modules\Asset\Models\AssetStatus', 'name', '', true);
    }
}
