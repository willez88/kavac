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

/**
 * @class PayrollStaffController
 * @brief Controlador de personal
 *
 * Clase que gestiona el personal
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollStaffController extends Controller
{
    use ValidatesRequests;

    /**
     * Muesta todos los registros de cargos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>\Illuminate\Http\Response</b>] $response Retorna la vista con los datos del personal
     */
    public function index()
    {
        $staffs = PayrollStaff::all();
        return view('payroll::staffs.index', compact('staffs'));
    }

    /**
     * Muestra el formulario para crear un nuevo personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>\Illuminate\Http\Response</b>] $response Retorna la vista con el formulario de registro
     */
    public function create()
    {
        $header = [
            'route' => 'staffs.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $marital_status = template_choices('App\Models\MaritalStatus');
        $professions = template_choices('App\Models\Profession');
        $countries = template_choices('App\Models\Country');
        $estates = template_choices('App\Models\Estate');
        $cities = template_choices('App\Models\City');
        return view('payroll::staffs.create-edit', compact(
            'header','marital_status','professions','countries','estates','cities'
        ));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|max:20',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'birthdate' => 'required|date',
            'sex' => 'required|max:1',
            'email' => 'required|email',
            'website' => 'required|max:255',
            'direction' => 'required',
            'sons' => 'required|integer',
            'start_date_public_adm' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'id_number' => 'required|max:12',
            'nationality' => 'required|max:100',
            'passport' => 'required|max:20',
            'marital_status_id' => 'required',
            'profession_id' => 'required',
            'city_id' => 'required'
        ]);
        $staff = new PayrollStaff;
        $staff->code  = $request->code;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->birthdate = $request->birthdate;
        $staff->sex = $request->sex;
        $staff->email = $request->email;
        $staff->active = ($request->input('active')!==null);
        $staff->website = $request->website;
        $staff->direction = $request->direction;
        $staff->sons = $request->sons;
        $staff->start_date_public_adm = $request->start_date_public_adm;
        $staff->start_date = $request->start_date;
        $staff->end_date = $request->end_date;
        $staff->id_number = $request->id_number;
        $staff->nationality = $request->nationality;
        $staff->passport = $request->passport;
        $staff->marital_status_id = $request->marital_status_id;
        $staff->profession_id = $request->profession_id;
        $staff->city_id = $request->city_id;
        $staff->save();
        return redirect()->route('staffs.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(PayrollStaff $staff)
    {
        $header = [
            'route' => ['staffs.update', $staff], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        $marital_status = template_choices('App\Models\MaritalStatus');
        $professions = template_choices('App\Models\Profession');
        $countries = template_choices('App\Models\Country');
        $estates = template_choices('App\Models\Estate');
        $cities = template_choices('App\Models\City');
        return view('payroll::staffs.create-edit', compact(
            'staff','header','marital_status','professions','countries','estates','cities'
        ));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollStaff $staff)
    {
        $this->validate($request, [
            'code' => 'required|max:20',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'birthdate' => 'required|date',
            'sex' => 'required|max:1',
            'email' => 'required|email',
            'website' => 'required|max:255',
            'direction' => 'required',
            'sons' => 'required|integer',
            'start_date_public_adm' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'id_number' => 'required|max:12',
            'nationality' => 'required|max:100',
            'passport' => 'required|max:20',
            'marital_status_id' => 'required',
            'profession_id' => 'required',
            'city_id' => 'required'
        ]);
        $staff->code  = $request->code;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->birthdate = $request->birthdate;
        $staff->sex = $request->sex;
        $staff->email  = $request->email;
        $staff->active = ($request->input('active')!==null);
        $staff->website = $request->website;
        $staff->direction = $request->direction;
        $staff->sons = $request->sons;
        $staff->start_date_public_adm = $request->start_date_public_adm;
        $staff->start_date = $request->start_date;
        $staff->end_date = $request->end_date;
        $staff->id_number = $request->id_number;
        $staff->nationality = $request->nationality;
        $staff->passport = $request->passport;
        $staff->marital_status_id = $request->marital_status_id;
        $staff->profession_id = $request->profession_id;
        $staff->city_id = $request->city_id;
        $staff->save();
        return redirect()->route('staffs.index');
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
        return redirect()->route('staffs.index');
    }
}
