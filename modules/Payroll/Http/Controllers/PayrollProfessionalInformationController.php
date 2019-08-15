<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollProfessionalInformation;

/**
 * @class PayrollProfessionalInformationController
 * @brief Controlador de información profesional del trabajador
 *
 * Clase que gestiona los datos de información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollProfessionalInformationController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.professional.informations.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.professional.informations.create', ['only' => 'store']);
        $this->middleware('permission:payroll.professional.informations.edit', ['only' => ['create', 'update']]);
        $this->middleware('permission:payroll.professional.informations.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::professional-informations.index');
    }

    /**
     * Muestra el formulario de registro de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::professional-informations.create-edit');
    }

    /**
     * Valida y registra una nueva información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payroll_staff_id' => 'required|unique:payroll_professional_informations,payroll_staff_id',
            'payroll_instruction_degree_id' => 'required',
            'payroll_language_id' => 'required',
            'payroll_language_level_id' => 'required'
        ]);

        $payrollProfessionalInformation = new PayrollProfessionalInformation;
        $payrollProfessionalInformation->payroll_staff_id = $request->payroll_staff_id;
        $payrollProfessionalInformation->payroll_instruction_degree_id = $request->payroll_instruction_degree_id;

        if ($request->payroll_instruction_degree_id == 1 || $request->payroll_instruction_degree_id == 2 ||
            $request->payroll_instruction_degree_id == 3 || $request->payroll_instruction_degree_id == 6 ||
            $request->payroll_instruction_degree_id == 7 || $request->payroll_instruction_degree_id == 8
        ) {
            $payrollProfessionalInformation->profession_id = null;
        } else {
            $this->validate($request, [
                'profession_id' => 'required'
            ]);
            $payrollProfessionalInformation->profession_id = $request->profession_id;
        }

        if ($request->payroll_instruction_degree_id == 6 || $request->payroll_instruction_degree_id == 7 ||
            $request->payroll_instruction_degree_id == 8
        ) {
            $this->validate($request, [
                'instruction_degree_name' => 'required'
            ]);
            $payrollProfessionalInformation->instruction_degree_name = $request->instruction_degree_name;
        }

        $payrollProfessionalInformation->is_student = $request->is_student;

        if ($payrollProfessionalInformation->is_student) {
            $this->validate($request, [
                'payroll_study_type_id' => 'required',
                'study_program_name' => 'required',
                'class_schedule' => 'required'
            ]);
            $payrollProfessionalInformation->payroll_study_type_id = $request->payroll_study_type_id;
            $payrollProfessionalInformation->study_program_name = $request->study_program_name;
            $payrollProfessionalInformation->class_schedule = $request->class_schedule;
        } else {
            $payrollProfessionalInformation->payroll_study_type_id = null;
            $payrollProfessionalInformation->study_program_name = null;
            $payrollProfessionalInformation->class_schedule = null;
        }

        $payrollProfessionalInformation->payroll_language_id = $request->payroll_language_id;
        $payrollProfessionalInformation->payroll_language_level_id = $request->payroll_language_level_id;
        $payrollProfessionalInformation->save();
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json([
            'result' => true, 'redirect' => route('payroll.professional-informations.index')
        ], 200);
    }

    /**
     * Muestra los datos de la información profesional del trabajador en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador del dato a mostrar
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información profesional del trabajador
     */
    public function show($id)
    {
        $payrollProfessionalInformation = PayrollProfessionalInformation::where('id', $id)->with([
            'payroll_staff','payroll_instruction_degree','profession','payroll_study_type',
            'payroll_language','payroll_language_level'
        ])->first();
        return response()->json(['record' => $payrollProfessionalInformation], 200);
    }

    /**
     * Muestra el formulario de actualización de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id              Identificador con el dato a actualizar
     * @return \Illuminate\View\View    Vista con el formulario y el objeto con el dato a actualizar
     */
    public function edit($id)
    {
        $payrollProfessionalInformation = PayrollProfessionalInformation::find($id);
        return view('payroll::professional-informations.create-edit', compact('payrollProfessionalInformation'));
    }

    /**
     * Actualiza la información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del dato a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollProfessionalInformation = PayrollProfessionalInformation::find($id);
        $this->validate($request, [
            'payroll_staff_id' => 'required|unique:payroll_professional_informations,
                                   payroll_staff_id,'.$payrollProfessionalInformation->id,
            'payroll_instruction_degree_id' => 'required',
            'payroll_language_id' => 'required',
            'payroll_language_level_id' => 'required'
        ]);

        $payrollProfessionalInformation->payroll_staff_id = $request->payroll_staff_id;
        $payrollProfessionalInformation->payroll_instruction_degree_id = $request->payroll_instruction_degree_id;

        if ($request->payroll_instruction_degree_id == 1 || $request->payroll_instruction_degree_id == 2 ||
            $request->payroll_instruction_degree_id == 3 || $request->payroll_instruction_degree_id == 6 ||
            $request->payroll_instruction_degree_id == 7 || $request->payroll_instruction_degree_id == 8
        ) {
            $payrollProfessionalInformation->profession_id = null;
        } else {
            $this->validate($request, [
                'profession_id' => 'required'
            ]);
            $payrollProfessionalInformation->profession_id = $request->profession_id;
        }

        if ($request->payroll_instruction_degree_id == 6 || $request->payroll_instruction_degree_id == 7 ||
            $request->payroll_instruction_degree_id == 8
        ) {
            $this->validate($request, [
                'instruction_degree_name' => 'required'
            ]);
            $payrollProfessionalInformation->instruction_degree_name = $request->instruction_degree_name;
        }

        if ($request->is_student) {
            $this->validate($request, [
                'payroll_study_type_id' => 'required',
                'study_program_name' => 'required',
                'class_schedule' => 'required'
            ]);
            $payrollProfessionalInformation->is_student = $request->is_student;
            $payrollProfessionalInformation->payroll_study_type_id = $request->payroll_study_type_id;
            $payrollProfessionalInformation->study_program_name = $request->study_program_name;
            $payrollProfessionalInformation->class_schedule = $request->class_schedule;
        } else {
            $payrollProfessionalInformation->is_student = false;
            $payrollProfessionalInformation->payroll_study_type_id = null;
            $payrollProfessionalInformation->study_program_name = null;
            $payrollProfessionalInformation->class_schedule = null;
        }

        $payrollProfessionalInformation->payroll_language_id = $request->payroll_language_id;
        $payrollProfessionalInformation->payroll_language_level_id = $request->payroll_language_level_id;
        $payrollProfessionalInformation->save();
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json([
            'result' => true, 'redirect' => route('payroll.professional-informations.index')
        ], 200);
    }

    /**
     * Elimina la información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del dato a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollProfessionalInformation = PayrollProfessionalInformation::find($id);
        $payrollProfessionalInformation->delete();
        return response()->json(['record' => $payrollProfessionalInformation, 'message' => 'Success'], 200);
    }

    /**
     * Muestra la información profesional del trabajador registrada
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información profesional
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollProfessionalInformation::with([
            'payroll_staff', 'payroll_instruction_degree','profession',
            'payroll_study_type','payroll_language','payroll_language_level'
        ])->get()], 200);
    }
}
