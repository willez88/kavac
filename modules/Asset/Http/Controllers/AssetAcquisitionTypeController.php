<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetAcquisitionType;
use Illuminate\Validation\Rule;

/**
 * @class      AssetAcquisitionTypeController
 * @brief      Controlador de los tipos de adquisición de bienes institucionales
 *
 * Clase que gestiona los tipos de adquisición de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetAcquisitionTypeController extends Controller
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
        //$this->middleware('permission:asset.setting.acquisition-type');
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'     => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100',
                            Rule::unique('asset_acquisition_types')]


        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'     => 'El campo tipo de adquisición es obligatorio.',
            'name.max'          => 'El campo tipo de adquisición no debe contener más de 100 caracteres.',
            'name.regex'        => 'El campo tipo de adquisición no debe permitir números ni símbolos.',
            'name.unique'       => 'El campo tipo de adquisición ya ha sido registrado'
           ];
    }

    /**
     * Muestra un listado de los tipos de adquisición bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetAcquisitionType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo adquisición de bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);
        /**
         * Objeto asociado al modelo AssetAcquisitionType
         *
         * @var Object $acquisition_type
         */
        $acquisition_type = AssetAcquisitionType::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $acquisition_type, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de adquisición de un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request                      $request             Datos de la petición
     * @param     \Modules\Asset\Models\AssetAcquisitionType    $acquisition_type    Datos del tipo de adquisición
     *                                                                               de un bien
     * @return    \Illuminate\Http\JsonResponse                 Objeto con los registros a mostrar
     */

    public function update(Request $request, AssetAcquisitionType $acquisition_type)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[a-zA-ZÁ-ÿ\s]*$/u', 'max:100',
                            Rule::unique('asset_acquisition_types')->ignore($acquisition_type->id)]]
        );

        $this->validate($request, $validateRules, $this->messages);

        $acquisition_type->name = $request->input('name');
        $acquisition_type->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de adquisición de un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetAcquisitionType    $acquisition_type    Datos del tipo de adquisición de
     *                                                                               un bien
     * @return    \Illuminate\Http\JsonResponse                 Objeto con los registros a mostrar
     */
    public function destroy(AssetAcquisitionType $acquisition_type)
    {
        $acquisition_type->delete();
        return response()->json(['record' => $acquisition_type, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de tipos de adquisición de los bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array Arreglo con los registros a mostrar
     */
    public function getAcquisitionTypes()
    {
        return template_choices('Modules\Asset\Models\AssetAcquisitionType', 'name', '', true);
    }
}
