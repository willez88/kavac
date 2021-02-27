<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollEmployment;
use Modules\Payroll\Models\PayrollStaff;
use Modules\Payroll\Models\Profile;

/**
 * @class PayrollEmploymentController
 * @brief Controlador de datos laborales
 *
 * Clase que gestiona los datos laborales
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollEmploymentController extends Controller
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
        $this->middleware('permission:payroll.employments.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.employments.create', ['only' => 'store']);
        $this->middleware('permission:payroll.employments.edit', ['only' => ['create', 'update']]);
        $this->middleware('permission:payroll.employments.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de datos laborales
     *
     * @method    index
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @return    Renderable    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::employments.index');
    }

    /**
     * Muestra el formulario de registro de datos laborales
     *
     * @method    create
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @return    Renderable    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::employments.create-edit');
    }

    /**
     * Valida y registra un nuevo dato laboral
     *
     * @method    store
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @param     object    Request    $request    Objeto con información de la petición
     *
     * @return    Renderable    Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $rules = [
            'payroll_staff_id' => ['required', 'unique:payroll_employments,payroll_staff_id'],
            'start_date_apn' => ['required', 'date', 'before_or_equal:start_date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'institution_email' => ['email', 'nullable', 'unique:payroll_employments,institution_email'],
            'function_description' => ['nullable'],
            'payroll_position_type_id' => ['required'],
            'payroll_position_id' => ['required'],
            'payroll_staff_type_id' => ['required'],
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'payroll_contract_type_id' => ['required'],
        ];
        if ($request->end_date) {
            array_push($rules['start_date_apn'], 'before_or_equal:end_date');
            array_push($rules['start_date'], 'before_or_equal:end_date');
            array_push($rules['end_date'], 'after_or_equal:start_date');
        }
        $this->validate($request, $rules);
        $payrollEmployment = new PayrollEmployment;
        $payrollEmployment->payroll_staff_id  = $request->payroll_staff_id;
        $payrollEmployment->start_date_apn = $request->start_date_apn;
        $payrollEmployment->start_date = $request->start_date;
        $payrollEmployment->end_date = $request->end_date;

        $payrollEmployment->active = $request->active;
        if ($payrollEmployment->active) {
            $payrollEmployment->payroll_inactivity_type_id = null;
        } else {
            $this->validate($request, [
                'payroll_inactivity_type_id' => ['required']
            ]);
            $payrollEmployment->active = false;
            $payrollEmployment->payroll_inactivity_type_id = $request->payroll_inactivity_type_id;
        }

        $payrollEmployment->institution_email = $request->institution_email;
        $payrollEmployment->function_description = $request->function_description;
        $payrollEmployment->payroll_position_type_id = $request->payroll_position_type_id;
        $payrollEmployment->payroll_position_id = $request->payroll_position_id;
        $payrollEmployment->payroll_staff_type_id = $request->payroll_staff_type_id;
        $payrollEmployment->department_id = $request->department_id;
        $payrollEmployment->payroll_contract_type_id = $request->payroll_contract_type_id;
        $payrollEmployment->save();

        // Registrar ciertos datos del perfil
        $payrollStaff = PayrollStaff::find($request->payroll_staff_id);
        $profile = Profile::create([
            'first_name' => $payrollStaff->first_name, 'last_name' => $payrollStaff->last_name,
            'institution_id' => $payrollEmployment->department->institution_id,
            'employee_id' => $payrollEmployment->id,
        ]);
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.employments.index')], 200);
    }

    /**
     * Muestra los datos de un dato laboral en específico
     *
     * @method    show
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    Json con el dato laboral
     */
    public function show($id)
    {
        $payrollEmployment = PayrollEmployment::where('id', $id)->with([
            'payrollStaff', 'payrollInactivityType', 'payrollPositionType',
            'payrollPosition', 'payrollStaffType', 'department', 'payrollContractType'
        ])->first();
        return response()->json(['record' => $payrollEmployment], 200);
    }

    /**
     * Muestra el formulario de actualización de dato laboral
     *
     * @method    edit
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    Vista con el formulario y el objeto a actualizar
     */
    public function edit($id)
    {
        $payrollEmployment = PayrollEmployment::find($id);
        return view('payroll::employments.create-edit', compact('payrollEmployment'));
    }

    /**
     * Actualiza el dato laboral
     *
     * @method    update
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     *
     * @return    Renderable    Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollEmployment = PayrollEmployment::find($id);
        $this->validate($request, [
            'payroll_staff_id' => [
                'required',
                'unique:payroll_employments,payroll_staff_id,'.$payrollEmployment->id
            ],
            'start_date_apn' => ['required', 'date', 'before_or_equal:start_date', 'before_or_equal:end_date'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date'],
            'institution_email' => [
                'email','nullable',
                'unique:payroll_employments,institution_email,'.$payrollEmployment->id
            ],
            'function_description' => ['nullable'],
            'payroll_position_type_id' => ['required'],
            'payroll_position_id' => ['required'],
            'payroll_staff_type_id' => ['required'],
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'payroll_contract_type_id' => ['required'],
        ]);
        $payrollEmployment->payroll_staff_id  = $request->payroll_staff_id;
        $payrollEmployment->start_date_apn = $request->start_date_apn;
        $payrollEmployment->start_date = $request->start_date;
        $payrollEmployment->end_date = $request->end_date;

        $payrollEmployment->active = $request->active;
        if ($payrollEmployment->active) {
            $payrollEmployment->payroll_inactivity_type_id = null;
        } else {
            $this->validate($request, [
                'payroll_inactivity_type_id' => ['required']
            ]);
            $payrollEmployment->active = false;
            $payrollEmployment->payroll_inactivity_type_id = $request->payroll_inactivity_type_id;
        }

        $payrollEmployment->institution_email = $request->institution_email;
        $payrollEmployment->function_description = $request->function_description;
        $payrollEmployment->payroll_position_type_id = $request->payroll_position_type_id;
        $payrollEmployment->payroll_position_id = $request->payroll_position_id;
        $payrollEmployment->payroll_staff_type_id = $request->payroll_staff_type_id;
        //$payrollEmployment->institution_id = $request->institution_id;
        $payrollEmployment->department_id = $request->department_id;
        $payrollEmployment->payroll_contract_type_id = $request->payroll_contract_type_id;
        $payrollEmployment->save();
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.employments.index')], 200);
    }

    /**
     * Elimina el dato laboral
     *
     * @method    destroy
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollEmployment = PayrollEmployment::find($id);
        $payrollEmployment->delete();
        return response()->json(['record' => $payrollEmployment, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos laborales registrados
     *
     * @method    VueList
     *
     * @author    William Páez <wpaez@cenditel.gob.ve>
     *
     * @return    Renderable    Json con los datos laborales del trabajador
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollEmployment::with([
            'payrollStaff', 'payrollInactivityType', 'payrollPositionType',
            'payrollPosition', 'payrollStaffType', 'department', 'payrollContractType'
        ])->get()], 200);
    }
}
