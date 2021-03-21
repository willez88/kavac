<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollStaff;
use App\Models\Phone;
use App\Models\CodeSetting;
use App\Rules\AgeToWork;
use Modules\Payroll\Models\Parameter;

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

        /** Define las reglas de validación para el formulario */
        $this->rules = [
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'payroll_nationality_id' => ['required'],
            'id_number' => [],
            'passport' => [],
            'email' => [],
            'birthdate' => [],
            'payroll_gender_id' => ['required'],
            'emergency_contact' => ['nullable'],
            'emergency_phone' => ['nullable', 'regex:/^\+\d{2}-\d{3}-\d{7}$/u'],
            'payroll_blood_type_id' => ['required'],
            'social_security' => ['nullable'],
            'parish_id' => ['required'],
            'address' => ['required', 'max:200']
        ];

        /** Define los atributos para los campos personalizados*/
        $this->attributes = [
            'id_number' => 'cédula de identidad',
            'birthdate' => 'fecha de nacimiento',
            'emergency_phone' => 'télefono de contacto',
            'payroll_nationality_id' => 'nacionalidad',
            'payroll_gender_id' => 'género',
            'payroll_blood_type_id' => 'tipo de sangre',
            'parish_id' => 'parroquia',
        ];
    }

    /**
     * Muestra todos los registros de información personal del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return Renderable    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::staffs.index');
    }

    /**
     * Muestra el formulario de registro de información personal del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return Renderable    Vista con el formulario
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
        $parameter = Parameter::where([
            'active' => true, 'required_by' => 'payroll', 'p_key' => 'work_age'
        ])->first();
        $this->rules['id_number'] = ['required', 'regex:/^([\d]{7}|[\d]{8})$/u', 'unique:payroll_staffs,id_number'];
        $this->rules['passport'] = ['nullable', 'max:20', 'unique:payroll_staffs,passport'];
        $this->rules['email'] = ['nullable', 'email', 'unique:payroll_staffs,email'];
        $this->rules['birthdate'] = ['required', 'date', new AgeToWork(($parameter) ? $parameter->p_value : 0)];
        $this->validate($request, $this->rules, [], $this->attributes);
        if ($request->has_disability) {
            $this->validate(
                $request,
                [
                    'payroll_disability_id' => ['required'],
                ],
                [],
                [
                    'payroll_disability_id' => 'discapacidad'
                ],
            );
        }
        if ($request->has_driver_license) {
            $this->validate(
                $request,
                [
                    'payroll_license_degree_id' => ['required'],
                ],
                [],
                [
                    'payroll_license_degree_id' => 'grado de licencia de conducir'
                ],
            );
        }

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate(
                $request,
                [
                    'phones.'.$i.'.type' => ['required'],
                    'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                    'phones.'.$i.'.number' => ['required', 'digits:7'],
                    'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
                ],
                [],
                [
                    'phones.'.$i.'.type' => 'tipo #'.$i+1,
                    'phones.'.$i.'.area_code' => 'código de area #'.$i+1,
                    'phones.'.$i.'.number' => 'número #'.$i+1,
                    'phones.'.$i.'.extension' => 'extensión #'.$i+1,
                ]
            );
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
        $payrollStaff = PayrollStaff::create([
            'code' => generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                $codeSetting->model,
                $codeSetting->field
            ),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'payroll_nationality_id' => $request->payroll_nationality_id,
            'id_number' => $request->id_number,
            'passport' => $request->passport,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'payroll_gender_id' => $request->payroll_gender_id,
            'has_disability' => ($request->has_disability!==null),
            'payroll_disability_id' => ($request->has_disability) ? $request->payroll_disability_id : null,
            'has_driver_license' => ($request->has_driver_license!==null),
            'payroll_license_degree_id' => ($request->has_driver_license) ? $request->payroll_license_degree_id : null,
            'social_security' => $request->social_security,
            'payroll_blood_type_id' => $request->payroll_blood_type_id,
            'emergency_contact' => $request->emergency_contact,
            'emergency_phone' => $request->emergency_phone,
            'parish_id' => $request->parish_id,
            'address' => $request->address,
        ]);
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
            'payrollNationality','payrollGender','payrollLicenseDegree','payrollBloodType','payrollDisability',
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
     * @return Renderable    Vista con el formulario y el objeto con el dato a actualizar
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
        $parameter = Parameter::where([
            'active' => true, 'required_by' => 'payroll', 'p_key' => 'work_age'
        ])->first();
        $payrollStaff = PayrollStaff::find($id);
        $this->rules['id_number'] = [
            'required', 'regex:/^([\d]{7}|[\d]{8})$/u', 'unique:payroll_staffs,id_number,'.$payrollStaff->id
        ];
        $this->rules['passport'] = ['nullable', 'max:20', 'unique:payroll_staffs,passport,'.$payrollStaff->id];
        $this->rules['email'] = ['nullable', 'email', 'unique:payroll_staffs,email,'.$payrollStaff->id];
        $this->rules['birthdate'] = ['required', 'date', new AgeToWork(($parameter) ? $parameter->p_value : 0)];
        $this->validate($request, $this->rules, [], $this->attributes);
        if ($request->has_disability) {
            $this->validate(
                $request,
                [
                    'payroll_disability_id' => ['required'],
                ],
                [],
                [
                    'payroll_disability_id' => 'discapacidad'
                ],
            );
        }
        if ($request->has_driver_license) {
            $this->validate(
                $request,
                [
                    'payroll_license_degree_id' => ['required'],
                ],
                [],
                [
                    'payroll_license_degree_id' => 'grado de licencia de conducir'
                ],
            );
        }
        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate(
                $request,
                [
                    'phones.'.$i.'.type' => ['required'],
                    'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                    'phones.'.$i.'.number' => ['required', 'digits:7'],
                    'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
                ],
                [],
                [
                    'phones.'.$i.'.type' => 'tipo #'.$i+1,
                    'phones.'.$i.'.area_code' => 'código de area #'.$i+1,
                    'phones.'.$i.'.number' => 'número #'.$i+1,
                    'phones.'.$i.'.extension' => 'extensión #'.$i+1,
                ]
            );
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
        $payrollStaff->has_disability = ($request->has_disability!==null);
        $payrollStaff->payroll_disability_id = ($request->has_disability) ? $request->payroll_disability_id : null;
        $payrollStaff->has_driver_license = ($request->has_driver_license!==null);
        $payrollStaff->payroll_license_degree_id = ($request->has_driver_license) ?
            $request->payroll_license_degree_id : null;
        $payrollStaff->social_security = $request->social_security;
        $payrollStaff->payroll_blood_type_id = $request->payroll_blood_type_id;
        $payrollStaff->emergency_contact = $request->emergency_contact;
        $payrollStaff->emergency_phone = $request->emergency_phone;
        $payrollStaff->parish_id = $request->parish_id;
        $payrollStaff->address = $request->address;
        $payrollStaff->save();
        foreach ($payrollStaff->phones as $phone) {
            $phone->delete();
        }
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
            'payrollNationality','payrollGender','parish','payrollLicenseDegree','payrollBloodType','payrollDisability'
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
        return response()->json(template_choices(PayrollStaff::class, ['id_number','-','full_name'], '', true));
    }
}
