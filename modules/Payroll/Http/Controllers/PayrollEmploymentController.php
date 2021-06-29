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
use App\Models\Phone;
use App\Models\CodeSetting;
use App\Rules\AgeToWork;
use Modules\Payroll\Models\Parameter;
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

        /** Define las reglas de validación para el formulario */
        $this->rules = [
            'start_date_apn' => ['required', 'date', 'before_or_equal:start_date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'function_description' => ['nullable'],
            'payroll_position_type_id' => ['required'],
            'payroll_position_id' => ['required'],
            'payroll_staff_type_id' => ['required'],
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'payroll_contract_type_id' => ['required'],
        ];

        /** Define los atributos para los campos personalizados */
        $this->attributes = [
            'start_date_apn' => 'fecha de ingreso a la administración pública',
            'start_date' => 'fecha de ingreso a la institución',
            'end_date' => 'fecha de egreso de la institución',
            'function_description' => 'descripción de funciones',
            'payroll_position_type_id' => 'tipo de cargo',
            'payroll_position_id' => 'cargo',
            'payroll_staff_type_id' => 'tipo de personal',
            'institution_id' => 'institución',
            'department_id' => 'departamento',
            'payroll_contract_type_id' => 'tipo de contracto',
        ];
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
        $this->rules['payroll_staff_id'] = ['required', 'unique:payroll_employments,payroll_staff_id'];
        $this->rules['institution_email'] = ['email', 'nullable', 'unique:payroll_employments,institution_email'];
        if ($request->end_date) {
            $this->rules['start_date_apn'] = ['before_or_equal:end_date'];
            $this->rules['start_date'] = ['before_or_equal:end_date'];
            $this->rules['end_date'] = ['after_or_equal:start_date'];
        }
        if (!$request->active) {
            $this->validate(
                $request,
                [
                    'payroll_inactivity_type_id' => ['required'],
                ],
                [],
                [
                    'payroll_inactivity_type_id' => 'tipo de inactividad',
                ],
            );
        }
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollEmployment = PayrollEmployment::create([
            'payroll_staff_id' => $request->payroll_staff_id,
            'start_date_apn' => $request->start_date_apn,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => ($request->active!==null),
            'payroll_inactivity_type_id' => (!$request->active) ? $request->payroll_inactivity_type_id : null,
            'institution_email' => $request->institution_email,
            'function_description' => $request->function_description,
            'payroll_position_type_id' => $request->payroll_position_type_id,
            'payroll_position_id' => $request->payroll_position_id,
            'payroll_staff_type_id' => $request->payroll_staff_type_id,
            'department_id' => $request->department_id,
            'payroll_contract_type_id' => $request->payroll_contract_type_id,
        ]);

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
            'payrollStaff'=> function ($query) {
                $query->with('payrollNationality','payrollGender','payrollLicenseDegree','payrollBloodType','payrollDisability',);
            }, 'payrollInactivityType', 'payrollPositionType',
            'payrollPosition', 'payrollStaffType', 'department', 'payrollContractType'
        ])->first();
        return response()->json(['record' => $payrollEmployment, 'age' => age($payrollEmployment->payrollStaff->birthdate)], 200);
        
       
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
        $this->rules['payroll_staff_id'] = [
            'required', 'unique:payroll_employments,payroll_staff_id,'.$payrollEmployment->id
        ];
        $this->rules['institution_email'] = [
            'email', 'nullable', 'unique:payroll_employments,institution_email,'.$payrollEmployment->id
        ];
        if ($request->end_date) {
            $this->rules['start_date_apn'] = ['before_or_equal:end_date'];
            $this->rules['start_date'] = ['before_or_equal:end_date'];
            $this->rules['end_date'] = ['after_or_equal:start_date'];
        }
        if (!$request->active) {
            $this->validate(
                $request,
                [
                    'payroll_inactivity_type_id' => ['required'],
                ],
                [],
                [
                    'payroll_inactivity_type_id' => 'tipo de inactividad',
                ],
            );
        }
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollEmployment->payroll_staff_id  = $request->payroll_staff_id;
        $payrollEmployment->start_date_apn = $request->start_date_apn;
        $payrollEmployment->start_date = $request->start_date;
        $payrollEmployment->end_date = $request->end_date;
        $payrollEmployment->active = ($request->active!==null);
        $payrollEmployment
            ->payroll_inactivity_type_id = (!$request->active) ? $request->payroll_inactivity_type_id : null;
        $payrollEmployment->institution_email = $request->institution_email;
        $payrollEmployment->function_description = $request->function_description;
        $payrollEmployment->payroll_position_type_id = $request->payroll_position_type_id;
        $payrollEmployment->payroll_position_id = $request->payroll_position_id;
        $payrollEmployment->payroll_staff_type_id = $request->payroll_staff_type_id;
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
