<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollNationality;
use App\Models\Country;

/**
 * @class PayrollNationalityController
 * @brief Controlador de nacionalidad
 *
 * Clase que gestiona las nacionalidades
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollNationalityController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.nationalities.index', ['only' => 'index']);
        $this->middleware('permission:payroll.nationalities.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.nationalities.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.nationalities.delete', ['only' => 'destroy']);
    }

    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $nationalities = PayrollNationality::all();
        return view('payroll::nationalities.index', compact('nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'nationalities.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $countries = template_choices('App\Models\Country');
        return view('payroll::nationalities.create-edit', compact('header','countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'demonym' => 'required|max:100',
            'country_id' => 'required|unique:payroll_nationalities'
        ]);
        $nationality = new PayrollNationality;
        $nationality->demonym = $request->demonym;
        $nationality->country_id = $request->country_id;
        $nationality->save();
        return redirect()->route('nationalities.index');
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
    public function edit(PayrollNationality $nationality)
    {
        $header = [
            'route' => ['nationalities.update', $nationality], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        $countries = template_choices('App\Models\Country');
        return view('payroll::nationalities.create-edit', compact('nationality','header','countries'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollNationality $nationality)
    {
        $this->validate($request, [
            'demonym' => 'required|max:100',
            'country_id' => 'required|unique:payroll_nationalities'
        ]);
        $nationality = new PayrollNationality;
        $nationality->demonym = $request->demonym;
        $nationality->country_id = $request->country_id;
        $nationality->save();
        return redirect()->route('nationalities.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollNationality $nationality)
    {
        if ($request->ajax()) {
            $nationality->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('nationalities.index');
    }
}
