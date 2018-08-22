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
            'route' => 'staff.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $marital_status = MaritalStatus::template_choices();
        $professions = Profession::template_choices();
        $countries = Country::template_choices();
        $estates = Estate::template_choices();
        $cities = City::template_choices();
        return view('payroll::staffs.create-edit', compact('header','marital_status','professions','countries','estates','cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
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
    public function edit()
    {
        return view('payroll::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
