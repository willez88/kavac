<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollStaff;
use App\Models\MaritalStatus;
use App\Models\Profession;
use App\Models\Country;
use App\Models\Estate;
use App\Models\City;
use Modules\Payroll\Models\PayrollNationality;
use App\Models\CodeSetting;
use App\Helpers\Helper;

/**
 * @class PayrollStaffController
 * @brief Controlador de personal
 *
 * Clase que gestiona el personal
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
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
        $this->middleware('permission:payroll.staffs.list', ['only' => 'index']);
        $this->middleware('permission:payroll.staffs.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.staffs.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.staffs.delete', ['only' => 'destroy']);
    }

    /**
     * Muesta todos los registros de cargos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>\Illuminate\Http\Response</b>] $response Retorna la vista con los datos del personal
     */
    public function index()
    {
        return view('payroll::staffs.index');
    }

    /**
     * Muestra el formulario para crear un nuevo personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>\Illuminate\Http\Response</b>] $response Retorna la vista con el formulario de registro
     */
    public function create()
    {
        return view('payroll::staffs.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'payroll_nationality_id' => 'required',
            'id_number' => 'required|regex:/^[\d]{8}$/u|unique:payroll_staffs,id_number',
            'passport' => 'nullable|max:20|unique:payroll_staffs,passport',
            'email' => 'nullable|email|unique:payroll_staffs,email',
            'birthdate' => 'required|date',
            'payroll_gender_id' => 'required',
            'emergency_contact' => 'nullable',
            'emergency_phone' => 'nullable',
            'parish_id' => 'required',
            'address' => 'required|max:200'
        ]);

        $codeSetting = CodeSetting::where('table', 'payroll_staffs')->first();
        if (!$codeSetting) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]], 200);
        }

        $staff = new PayrollStaff;
        $staff->code  = generate_registration_code($codeSetting->format_prefix, strlen($codeSetting->format_digits),
        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'), $codeSetting->model, $codeSetting->field);
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->payroll_nationality_id = $request->payroll_nationality_id;
        $staff->id_number = $request->id_number;
        $staff->passport = $request->passport;
        $staff->email = $request->email;
        $staff->birthdate = $request->birthdate;
        $staff->payroll_gender_id = $request->payroll_gender_id;
        $staff->emergency_contact = $request->emergency_contact;
        $staff->emergency_phone = $request->emergency_phone;
        $staff->parish_id = $request->parish_id;
        $staff->address = $request->address;
        $staff->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $staff->phones()->save(new Phone([
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
     * Muesta el detalle completo de los datos de un personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>\Illuminate\Http\Response</b>] $response Retorna el json de un registro de personal
     */
    public function show($id)
    {
        $payroll_staff = PayrollStaff::where('id',$id)->with(['payroll_nationality','payroll_gender','parish','phones'])->first();
        return response()->json(['record' => $payroll_staff], 200);
    }

    public function info($id)
    {
        $payroll_staff = PayrollStaff::findorfail($id);
        $data[] = [
            'code' => $payroll_staff->code,
            'first_name' => $payroll_staff->first_name,
            'last_name' => $payroll_staff->last_name,
            'payroll_nationality' => $payroll_staff->payroll_nationality->name,
            'id_number' => $payroll_staff->id_number,
            'passport' => $payroll_staff->passport,
            'email' => $payroll_staff->email,
            'birthdate' => $payroll_staff->birthdate,
            'payroll_gender' => $payroll_staff->payroll_gender,
            'emergency_contact' => $payroll_staff->emergency_contact,
            'emergency_phone' => $payroll_staff->emergency_phone,
            'country' => $payroll_staff->parish->municipality->estate->country->name,
            'estate' => $payroll_staff->parish->municipality->estate->name,
            'municipality' => $payroll_staff->parish->municipality->name,
            'parish' => $payroll_staff->parish->name,
            'address' => $payroll_staff->address,
        ];
        return response()->json(['record' => $data[0]], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $payroll_staff = PayrollStaff::find($id);
        return view('payroll::staffs.create-edit', compact('payroll_staff'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollStaff $staff)
    {
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'payroll_nationality_id' => 'required',
            'id_number' => 'required|regex:/^[\d]{8}$/u',
            'passport' => 'max:20',
            'email' => 'nullable|email',
            'birthdate' => 'required|date',
            'payroll_gender_id' => 'required',
            'emergency_contact' => 'nullable',
            'emergency_phone' => 'nullable',
            'parish_id' => 'required',
            'address' => 'required|max:200'
        ]);
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->payroll_nationality_id = $request->payroll_nationality_id;
        $staff->id_number = $request->id_number;
        $staff->passport = $request->passport;
        $staff->email  = $request->email;
        $staff->birthdate = $request->birthdate;
        $staff->payroll_gender_id = $request->payroll_gender_id;
        $staff->emergency_contact = $request->emergency_contact;
        $staff->emergency_phone = $request->emergency_phone;
        $staff->parish_id = $request->parish_id;
        $staff->address = $request->address;
        $staff->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('payroll.staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollStaff $staff)
    {
        if ($request->ajax()) {
            $staff->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('payroll.staffs.index');
    }

    public function vueList()
    {
        return response()->json(['records' => PayrollStaff::with(['payroll_nationality','payroll_gender','parish'])->get()], 200);
    }

    public function getPayrollStaffs()
    {
        return template_choices('Modules\Payroll\Models\PayrollStaff',['id_number','-','full_name'],'',true);
    }
}
