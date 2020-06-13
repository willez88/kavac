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
     * Arreglo con los registros de opciones a asignar el concepto
     *
     * @var Array $assignTo
     */
    protected $assignTo;

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

        /** Define las opciones del campo "asignar a" a emplear en el formulario */
        $this->assignTo = [
            [
                'id'   => 'all',
                'name' => 'Todos los trabajadores',
                'required' => ''
            ],
            [
                'id'   => 'all_active_staff',
                'name' => 'Todos los trabajadores activos',
                'required' => ''
            ],
            [
                'id'   => 'all_except_staffs_in_vacation',
                'name' => 'Todos excepto trabajadores que se encuentren en período de vacaciones',
                'required' => ''
            ],
            [
                'id'   => 'all_except_staffs_at_rest',
                'name' => 'Todos excepto trabajadores que se encuentren de reposo',
                'required' => ''
            ],
            [
                'id'   => 'all_except_staffs_in_vacation_and_rest',
                'name' => 'Todos excepto trabajadores que se encuentren en período de vacaciones y reposo',
                'required' => ''
            ],
            [
                'id'   => 'all_except_disabled_staff',
                'name' => 'Todos excepto trabajadores discapacitados',
                'required' => ''
            ],
            [
                'id'   => 'all_except_staff_on_leave',
                'name' => 'Todos excepto trabajadores que se encuentren de permiso',
                'required' => ''
            ],
            [
                'id'   => 'all_retired_staff',
                'name' => 'Todos los trabajadores jubilados',
                'required' => ''
            ],
            [
                'id'   => 'all_disabled_staff',
                'name' => 'Todos los trabajadores con discapacidad',
                'required' => ''
            ],
            [
                'id'   => 'all_studying_staff',
                'name' => 'Todos los trabajadores que cursen estudios',
                'required' => ''
            ],
            [
                'id'   => 'all_staff_with_sons',
                'name' => 'Todos los trabajadores con hijos',
                'required' => ''
            ],
            [
                'id'   => 'all_staff_with_sons_studying',
                'name' => 'Todos los trabajadores con hijos que cursen estudios',
                'required' => ''
            ],
            [
                'id'   => 'staff',
                'name' => 'Trabajadores',
                'required' => 'STAFF'
            ],
            [
                'id'   => 'staff_master_the_languages',
                'name' => 'Trabajadores que dominen más de un idioma',
                'required' => 'LANGUAGE'
            ],
            [
                'id'   => 'staff_according_instruction_degree',
                'name' => 'Trabajadores de acuerdo su nivel de instrucción',
                'required' => 'INSTRUCTION_DEGREE'
            ],
            [
                'id'   => 'staff_according_antiquity_years',
                'name' => 'Trabajadores de acuerdo sus años de antiguedad',
                'required' => '' /** Lista de ragos de antiguedad? */
            ],
            [
                'id'   => 'staff_according_department',
                'name' => 'Trabajadores de acuerdo al departamento al que pertenece',
                'required' => 'DEPARTMENT'
            ],
            [
                'id'   => 'staff_according_position_type',
                'name' => 'Trabajadores de acuerdo al tipo de cargo al que pertenece',
                'required' => 'POSITION_TYPE'
            ],
            [
                'id'   => 'staff_according_contract_type',
                'name' => 'Trabajadores de acuerdo al tipo de contrato al que pertenece',
                'required' => 'CONTRACT_TYPE'
            ],
            [
                'id'   => 'staff_according_rol',
                'name' => 'Trabajadores de acuerdo al rol al que pertenece',
                'required' => 'ROL'
            ],
            [
                'id'   => 'staff_according_staff_type',
                'name' => 'Trabajadores de acuerdo al tipo de personal al que pertenece',
                'required' => 'STAFF_TYPE'
            ],
            [
                'id'   => 'staff_according_gender',
                'name' => 'Trabajadores de acuerdo al género al que pertenece',
                'required' => 'GENDER'
            ],
            [
                'id'   => 'staff_according_years_old',
                'name' => 'Trabajadores de acuerdo a la edad que poseen',
                'required' => '' /** Lista de ragos de edad? */
            ]
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
        return response()->json(['message' => 'Success'], 200);

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
        return response()->json(['message' => 'Success'], 200);
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
     * @return    Array          Listado de los registros a mostrar
     */
    public function getPayrollConcepts()
    {
        return template_choices('Modules\Payroll\Models\PayrollConcept', ['code', '-', 'name'], '', true);
    }

    /**
     * Obtiene los tipos de conceptos registrados
     *
     * @method    getPayrollConceptAssignTo
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array          Listado de los registros a mostrar
     */
    public function getPayrollConceptAssignTo()
    {
        return $this->assignTo;
    }
}
