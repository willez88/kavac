<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollEmploymentInformation;
use App\Models\Profile;
use Modules\Payroll\Models\PayrollStaff;

/**
 * @class PayrollEmploymentInformationController
 * @brief Controlador de información laboral
 *
 * Clase que gestiona los datos de información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollEmploymentInformationController extends Controller
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
        $this->middleware('permission:payroll.employment.informations.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.employment.informations.create', ['only' => 'store']);
        $this->middleware('permission:payroll.employment.informations.edit', ['only' => ['create', 'update']]);
        $this->middleware('permission:payroll.employment.informations.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de información laboral
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::employment-informations.index');
    }

    /**
     * Muestra el formulario de registro de información laboral
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::employment-informations.create-edit');
    }

    /**
     * Valida y registra una nueva información laboral
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payroll_staff_id' => ['required', 'unique:payroll_employment_informations,payroll_staff_id'],
            'start_date_apn' => ['required', 'date', 'before_or_equal:start_date', 'before_or_equal:end_date'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date'],
            'institution_email' => ['email', 'nullable', 'unique:payroll_employment_informations,institution_email'],
            'function_description' => ['nullable'],
            'payroll_position_type_id' => ['required'],
            'payroll_position_id' => ['required'],
            'payroll_staff_type_id' => ['required'],
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'payroll_contract_type_id' => ['required'],
        ]);
        $payrollEmploymentInformation = new PayrollEmploymentInformation;
        $payrollEmploymentInformation->payroll_staff_id  = $request->payroll_staff_id;
        $payrollEmploymentInformation->start_date_apn = $request->start_date_apn;
        $payrollEmploymentInformation->start_date = $request->start_date;
        $payrollEmploymentInformation->end_date = $request->end_date;

        $payrollEmploymentInformation->active = $request->active;
        if ($payrollEmploymentInformation->active) {
            $payrollEmploymentInformation->payroll_inactivity_type_id = null;
        } else {
            $this->validate($request, [
                'payroll_inactivity_type_id' => ['required']
            ]);
            $payrollEmploymentInformation->active = false;
            $payrollEmploymentInformation->payroll_inactivity_type_id = $request->payroll_inactivity_type_id;
        }

        $payrollEmploymentInformation->institution_email = $request->institution_email;
        $payrollEmploymentInformation->function_description = $request->function_description;
        $payrollEmploymentInformation->payroll_position_type_id = $request->payroll_position_type_id;
        $payrollEmploymentInformation->payroll_position_id = $request->payroll_position_id;
        $payrollEmploymentInformation->payroll_staff_type_id = $request->payroll_staff_type_id;
        $payrollEmploymentInformation->department_id = $request->department_id;
        $payrollEmploymentInformation->payroll_contract_type_id = $request->payroll_contract_type_id;
        $payrollEmploymentInformation->save();

        // Registrar ciertos datos del perfil
        $payrollStaff = PayrollStaff::find($request->payroll_staff_id);
        $profile = Profile::create([
            'first_name' => $payrollStaff->first_name, 'last_name' => $payrollStaff->last_name,
            'institution_id' => $payrollEmploymentInformation->department->institution_id,
            'employee_id' => $payrollEmploymentInformation->id,
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.employment-informations.index')], 200);
    }

    /**
     * Muestra los datos de una información laboral en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador de la información laboral
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información laboral
     */
    public function show($id)
    {
        $payrollEmploymentInformation = PayrollEmploymentInformation::where('id', $id)->with([
            'payrollStaff', 'payrollInactivityType', 'payrollPositionType',
            'payrollPosition', 'payrollStaffType', 'department', 'payrollContractType'
        ])->first();
        return response()->json(['record' => $payrollEmploymentInformation], 200);
    }

    /**
     * Muestra el formulario de actualización de información laboral
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id              Identificador con el dato a actualizar
     * @return \Illuminate\View\View    Vista con el formulario y el objeto con el dato a actualizar
     */
    public function edit($id)
    {
        $payrollEmploymentInformation = PayrollEmploymentInformation::find($id);
        return view('payroll::employment-informations.create-edit', compact('payrollEmploymentInformation'));
    }

    /**
     * Actualiza la información laboral
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del dato a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollEmploymentInformation = PayrollEmploymentInformation::find($id);
        $this->validate($request, [
            'payroll_staff_id' => [
                'required',
                'unique:payroll_employment_informations,payroll_staff_id,'.$payrollEmploymentInformation->id
            ],
            'start_date_apn' => ['required', 'date', 'before_or_equal:start_date', 'before_or_equal:end_date'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date'],
            'institution_email' => [
                'email','nullable',
                'unique:payroll_employment_informations,institution_email,'.$payrollEmploymentInformation->id
            ],
            'function_description' => ['nullable'],
            'payroll_position_type_id' => ['required'],
            'payroll_position_id' => ['required'],
            'payroll_staff_type_id' => ['required'],
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'payroll_contract_type_id' => ['required'],
        ]);
        $payrollEmploymentInformation->payroll_staff_id  = $request->payroll_staff_id;
        $payrollEmploymentInformation->start_date_apn = $request->start_date_apn;
        $payrollEmploymentInformation->start_date = $request->start_date;
        $payrollEmploymentInformation->end_date = $request->end_date;

        $payrollEmploymentInformation->active = $request->active;
        if ($payrollEmploymentInformation->active) {
            $payrollEmploymentInformation->payroll_inactivity_type_id = null;
        } else {
            $this->validate($request, [
                'payroll_inactivity_type_id' => ['required']
            ]);
            $payrollEmploymentInformation->active = false;
            $payrollEmploymentInformation->payroll_inactivity_type_id = $request->payroll_inactivity_type_id;
        }

        $payrollEmploymentInformation->institution_email = $request->institution_email;
        $payrollEmploymentInformation->function_description = $request->function_description;
        $payrollEmploymentInformation->payroll_position_type_id = $request->payroll_position_type_id;
        $payrollEmploymentInformation->payroll_position_id = $request->payroll_position_id;
        $payrollEmploymentInformation->payroll_staff_type_id = $request->payroll_staff_type_id;
        //$payrollEmploymentInformation->institution_id = $request->institution_id;
        $payrollEmploymentInformation->department_id = $request->department_id;
        $payrollEmploymentInformation->payroll_contract_type_id = $request->payroll_contract_type_id;
        $payrollEmploymentInformation->save();
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.employment-informations.index')], 200);
    }

    /**
     * Elimina la información laboral
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del dato a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollEmploymentInformation = PayrollEmploymentInformation::find($id);
        $payrollEmploymentInformation->delete();
        return response()->json(['record' => $payrollEmploymentInformation, 'message' => 'Success'], 200);
    }

    /**
     * Muestra la información laboral registrada
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información laboral
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollEmploymentInformation::with([
            'payrollStaff', 'payrollInactivityType', 'payrollPositionType',
            'payrollPosition', 'payrollStaffType', 'department', 'payrollContractType'
        ])->get()], 200);
    }
}
