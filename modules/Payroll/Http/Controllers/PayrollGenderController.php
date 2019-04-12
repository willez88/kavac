<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollGender;

/**
 * @class PayrollGenderController
 * @brief Controlador del género
 *
 * Clase que gestiona los géneros
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollGenderController extends Controller
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
        $this->middleware('permission:payroll.genders.list', ['only' => 'index']);
        $this->middleware('permission:payroll.genders.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.genders.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.genders.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $genders = PayrollGender::all();
        return view('payroll::genders.index', compact('genders'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'payroll.genders.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::genders.create-edit', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $gender = new PayrollGender;
        $gender->name  = $request->name;
        $gender->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('payroll.genders.index');
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
    public function edit(PayrollGender $gender)
    {
        $header = [
            'route' => ['payroll.genders.update', $gender], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::genders.create-edit', compact('gender','header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollGender $gender)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $gender->name  = $request->name;
        $gender->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('payroll.genders.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollGender $gender)
    {
        if ($request->ajax())
        {
            $gender->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('payroll.genders.index');
    }
}
