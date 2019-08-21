<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollStaff;
use App\Models\Phone;
use App\Models\CodeSetting;
use App\Rules\AgeToWork;
use Modules\Payroll\Models\PayrollWorkAgeSetting;

/**
 * @class PayrollStaffController
 * @brief Controlador de la información personal del trabajador
 *
 * Clase que gestiona la información personal del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollStaffController extends Controller
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
        $this->middleware('permission:payroll.staffs.list', ['only' => ['index','vueList']]);
        $this->middleware('permission:payroll.staffs.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.staffs.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.staffs.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de información personal del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::staffs.index');
    }

    /**
     * Muestra el formulario de registro de información personal del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::staffs.create-edit');
    }

    /**
     * Valida y registra una nueva información personal del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $payrollWorkAgeSetting = PayrollWorkAgeSetting::first();
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'payroll_nationality_id' => 'required',
            'id_number' => array('required', 'regex:/^([\d]{7}|[\d]{8})$/u','unique:payroll_staffs,id_number'),
            'passport' => 'nullable|max:20|unique:payroll_staffs,passport',
            'email' => 'nullable|email|unique:payroll_staffs,email',
            'birthdate' => 'required|date',
            'birthdate' => new AgeToWork(($payrollWorkAgeSetting) ? $payrollWorkAgeSetting->age : 0),
            'payroll_gender_id' => 'required',
            'emergency_contact' => 'nullable',
            'emergency_phone' => array('nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'),
            'parish_id' => 'required',
            'address' => 'required|max:200'
        ]);

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => 'required',
                'phones.'.$i.'.area_code' => 'required|digits:3',
                'phones.'.$i.'.number' => 'required|digits:7',
                'phones.'.$i.'.extension' => 'nullable|digits_between:3,6',
            ]);
            $i++;
        }

        $codeSetting = CodeSetting::where('table', 'payroll_staffs')->first();
        if (!$codeSetting) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
            ]);
            return response()->json(['result' => false, 'redirect' => route('payroll.settings.index')], 200);
        }

        $payrollStaff = new PayrollStaff;
        $payrollStaff->code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        $payrollStaff->first_name = $request->first_name;
        $payrollStaff->last_name = $request->last_name;
        $payrollStaff->payroll_nationality_id = $request->payroll_nationality_id;
        $payrollStaff->id_number = $request->id_number;
        $payrollStaff->passport = $request->passport;
        $payrollStaff->email = $request->email;
        $payrollStaff->birthdate = $request->birthdate;
        $payrollStaff->payroll_gender_id = $request->payroll_gender_id;
        $payrollStaff->emergency_contact = $request->emergency_contact;
        $payrollStaff->emergency_phone = $request->emergency_phone;
        $payrollStaff->parish_id = $request->parish_id;
        $payrollStaff->address = $request->address;
        $payrollStaff->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $payrollStaff->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.staffs.index')], 200);
    }

    /**
     * Muestra los datos de la información personal del trabajador en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador del dato a mostrar
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información personal del trabajador
     */
    public function show($id)
    {
        $payrollStaff = PayrollStaff::where('id', $id)->with([
            'payrollNationality','payrollGender',
            'parish' => function ($query) {
                $query->with(['municipality' => function ($query) {
                    $query->with(['estate' => function ($query) {
                        $query->with('country');
                    }]);
                }]);
            }, 'phones'
        ])->first();
        return response()->json(['record' => $payrollStaff, 'age' => age($payrollStaff->birthdate)], 200);
    }

    /**
     * Muestra el formulario de actualización de información personal del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id              Identificador del dato a actualizar
     * @return \Illuminate\View\View    Vista con el formulario y el objeto con el dato a actualizar
     */
    public function edit($id)
    {
        $payrollStaff = PayrollStaff::find($id);
        return view('payroll::staffs.create-edit', compact('payrollStaff'));
    }

    /**
     * Actualiza la información personal del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del dato a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollWorkAgeSetting = PayrollWorkAgeSetting::first();
        $payrollStaff = PayrollStaff::find($id);
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'payroll_nationality_id' => 'required',
            'id_number' => array(
                'required', 'regex:/^([\d]{7}|[\d]{8})$/u', 'unique:payroll_staffs,id_number,'.$payrollStaff->id
            ),
            'passport' => 'nullable|max:20|unique:payroll_staffs,passport,'.$payrollStaff->id,
            'email' => 'nullable|email|unique:payroll_staffs,email,'.$payrollStaff->id,
            'birthdate' => 'required|date',
            'birthdate' => new AgeToWork(($payrollWorkAgeSetting) ? $payrollWorkAgeSetting->age : 0),
            'payroll_gender_id' => 'required',
            'emergency_contact' => 'nullable',
            'emergency_phone' => array('nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'),
            'parish_id' => 'required',
            'address' => 'required|max:200'
        ]);

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => 'required',
                'phones.'.$i.'.area_code' => 'required|digits:3',
                'phones.'.$i.'.number' => 'required|digits:7',
                'phones.'.$i.'.extension' => 'nullable|digits_between:3,6',
            ]);
            $i++;
        }

        $payrollStaff->first_name = $request->first_name;
        $payrollStaff->last_name = $request->last_name;
        $payrollStaff->payroll_nationality_id = $request->payroll_nationality_id;
        $payrollStaff->id_number = $request->id_number;
        $payrollStaff->passport = $request->passport;
        $payrollStaff->email  = $request->email;
        $payrollStaff->birthdate = $request->birthdate;
        $payrollStaff->payroll_gender_id = $request->payroll_gender_id;
        $payrollStaff->emergency_contact = $request->emergency_contact;
        $payrollStaff->emergency_phone = $request->emergency_phone;
        $payrollStaff->parish_id = $request->parish_id;
        $payrollStaff->address = $request->address;
        $payrollStaff->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $payrollStaff->phones()->updateOrCreate(
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ],
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ]
                );
            }
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.staffs.index')], 200);
    }

    /**
     * Elimina la información personal del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del dato a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollStaff = PayrollStaff::find($id);
        $payrollStaff->delete();
        return response()->json(['record' => $payrollStaff, 'message' => 'Success'], 200);
    }

    /**
     * Muestra la información laboral personal del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información personal del trabajador
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollStaff::with([
            'payrollNationality','payrollGender','parish'
        ])->get()], 200);
    }

    /**
     * Obtiene la información personal de los trabajadores
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información personal de los trabajadores
     */
    public function getPayrollStaffs()
    {
        return response()->json(template_choices(
            'Modules\Payroll\Models\PayrollStaff',
            ['id_number','-','full_name'],
            '',
            true
        ));
    }
}
