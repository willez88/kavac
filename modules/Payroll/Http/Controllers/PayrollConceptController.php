<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollConcept;

/**
 * @class      PayrollConceptController
 * @brief      Controlador de conceptos
 *
 * Clase que gestiona los conceptos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollConceptController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     *
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     *
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.concept.list',   ['only' => 'index']);
        //$this->middleware('permission:payroll.concept.create', ['only' => 'store']);
        //$this->middleware('permission:payroll.concept.edit',   ['only' => 'update']);
        //$this->middleware('permission:payroll.concept.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'code'                    => ['required'],
            'name'                    => ['required'],
            'affect'                  => ['required'],
            'incidence_type'          => ['required'],
            'institution_id'          => ['required'],
            'payroll_concept_type_id' => ['required'],
            'payroll_assign_to_id'    => ['required'],
            'calculation_way_id'      => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'code.required'                    => 'El campo código es obligatorio.',
            'affect.required'                  => 'El campo ¿incide sobre? es obligatorio.',
            'incidence_type.required'          => 'El campo tipo de incidencia es obligatorio.',
            'institution_id.required'          => 'El campo institución es obligatorio.',
            'payroll_concept_type_id.required' => 'El campo tipo de concepto es obligatorio.',
            'payroll_assign_to_id.required'    => 'El campo ¿asignar a? es obligatorio.',
            'calculation_way_id.required'      => 'El campo forma de cálculo es obligatorio.'
        ];
    }
    
    /**
     * Muestra un listado de los conceptos registradas (activos e inactivos)
     *
     * @method    index
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollConcept::all()], 200);
    }

    /**
     * Valida y registra un nuevo concepto
     *
     * @method    store
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request     $request    Datos de la petición
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        /**
         * Objeto asociado al modelo PayrollConcept
         *
         * @var Object $payrollConcept
         */
        $payrollConcept = PayrollConcept::create([
            'code'                    => $request->code,
            'name'                    => $request->name,
            'description'             => $request->description,
            'active'                  => !empty($request->active)
                                            ? $request->active
                                            : false,
            'incidence_type'          => $request->incidence_type,
            'affect'                  => $request->affect,
            'payroll_concept_type_id' => $request->payroll_concept_type_id,
            'institution_id'          => $request->institution_id
        ]);
        return response()->json(['record' => $payrollConcept, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una asignación salarial
     *
     * @method    update
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto con la información del concepto a editar asociado al modelo PayrollConcept
         *
         * @var Object $payrollConcept
         */
        $payrollConcept = PayrollConcept::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $payrollConcept->code        = $request->code;
        $payrollConcept->name        = $request->name;
        $payrollConcept->description = $request->description;
        $payrollConcept->active      = !empty($request->active)
                                        ? $request->active
                                        : $payrollConcept->active;
        $payrollConcept->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un concepto
     *
     * @method    destroy
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer $id                      Identificador único del concepto a eliminar
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        /**
         * Objeto con la información del concepto a eliminar asociado al modelo PayrollConcept
         *
         * @var Object $payrollConcept
         */
        $payrollConcept = PayrollConcept::find($id);
        $payrollConcept->delete();
        return response()->json(['record' => $payrollConcept, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de conceptos registrados
     *
     * @method    getPayrollConcepts
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer $id    Identificador único del concepto a eliminar
     * @return    Array          Listado de los registros a mostrar
     */
    public function getPayrollConcepts()
    {
        return template_choices('Modules\Payroll\Models\PayrollConcept', ['code', '-', 'name'], '', true);
    }
}
