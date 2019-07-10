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
        $this->middleware('permission:payroll.staffs.list', ['only' => ['index','vueList']]);
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
            'birthdate' => 'required|date|',
            'birthdate' => new AgeToWork,
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

        $payroll_staff = new PayrollStaff;
        $payroll_staff->code  = generate_registration_code($codeSetting->format_prefix, strlen($codeSetting->format_digits),
        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'), $codeSetting->model, $codeSetting->field);
        $payroll_staff->first_name = $request->first_name;
        $payroll_staff->last_name = $request->last_name;
        $payroll_staff->payroll_nationality_id = $request->payroll_nationality_id;
        $payroll_staff->id_number = $request->id_number;
        $payroll_staff->passport = $request->passport;
        $payroll_staff->email = $request->email;
        $payroll_staff->birthdate = $request->birthdate;
        $payroll_staff->payroll_gender_id = $request->payroll_gender_id;
        $payroll_staff->emergency_contact = $request->emergency_contact;
        $payroll_staff->emergency_phone = $request->emergency_phone;
        $payroll_staff->parish_id = $request->parish_id;
        $payroll_staff->address = $request->address;
        //$payroll_staff->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $payroll_staff->phones()->save(new Phone([
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
        $payroll_staff = PayrollStaff::where('id',$id)->with([
            'payroll_nationality','payroll_gender',
            'parish' => function($query) {
                $query->with(['municipality' => function($query){
                    $query->with(['estate' => function($query){
                        $query->with('country');
                    }]);
                }]);
            },'phones'])->first();
        return response()->json(['record' => $payroll_staff], 200);
    }

    // Posiblemente esta función no haga falta
    public function info($id)
    {
        /*$payroll_staff = PayrollStaff::findorfail($id);
        $data[] = [
            'code' => $payroll_staff->code,
            'first_name' => $payroll_staff->first_name,
            'last_name' => $payroll_staff->last_name,
            'payroll_nationality' => $payroll_staff->payroll_nationality->name,
            'id_number' => $payroll_staff->id_number,
            'passport' => $payroll_staff->passport,
            'email' => $payroll_staff->email,
            'birthdate' => $payroll_staff->birthdate,
            'payroll_gender' => $payroll_staff->payroll_gender->name,
            'emergency_contact' => $payroll_staff->emergency_contact,
            'emergency_phone' => $payroll_staff->emergency_phone,
            'country' => $payroll_staff->parish->municipality->estate->country->name,
            'estate' => $payroll_staff->parish->municipality->estate->name,
            'municipality' => $payroll_staff->parish->municipality->name,
            'parish' => $payroll_staff->parish->name,
            'address' => $payroll_staff->address,
        ];
        return response()->json(['record' => $data[0]], 200);*/

        $payroll_staff = PayrollStaff::where('id',$id)->with(['payroll_nationality','payroll_gender','parish','phones'])->first();
        return response()->json(['test' => $payroll_staff], 200);
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
    public function update(Request $request, $id)
    {
        $payroll_staff = PayrollStaff::find($id);
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'payroll_nationality_id' => 'required',
            'id_number' => 'required|regex:/^[\d]{8}$/u|unique:payroll_staffs,id_number,'.$payroll_staff->id,
            'passport' => 'nullable|max:20|unique:payroll_staffs,passport,'.$payroll_staff->id,
            'email' => 'nullable|email|unique:payroll_staffs,email,'.$payroll_staff->id,
            'birthdate' => 'required|date',
            'birthdate' => new AgeToWork,
            'payroll_gender_id' => 'required',
            'emergency_contact' => 'nullable',
            'emergency_phone' => 'nullable',
            'parish_id' => 'required',
            'address' => 'required|max:200'
        ]);
        $payroll_staff->first_name = $request->first_name;
        $payroll_staff->last_name = $request->last_name;
        $payroll_staff->payroll_nationality_id = $request->payroll_nationality_id;
        $payroll_staff->id_number = $request->id_number;
        $payroll_staff->passport = $request->passport;
        $payroll_staff->email  = $request->email;
        $payroll_staff->birthdate = $request->birthdate;
        $payroll_staff->payroll_gender_id = $request->payroll_gender_id;
        $payroll_staff->emergency_contact = $request->emergency_contact;
        $payroll_staff->emergency_phone = $request->emergency_phone;
        $payroll_staff->parish_id = $request->parish_id;
        $payroll_staff->address = $request->address;
        $payroll_staff->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $payroll_staff->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.staffs.index')], 200);
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
