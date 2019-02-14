<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollInstructionDegree;

/**
 * @class PayrollInstructionDegreeController
 * @brief Controlador de grado de instrucción
 *
 * Clase que gestiona los grados de instrucción
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollInstructionDegreeController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.instruction.degrees.index', ['only' => 'index']);
        $this->middleware('permission:payroll.instruction.degrees.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.instruction.degrees.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.instruction.degrees.delete', ['only' => 'destroy']);
    }

    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $instruction_degrees = PayrollInstructionDegree::all();
        return view('payroll::instruction-degrees.index', compact('instruction_degrees'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'instruction-degrees.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::instruction-degrees.create-edit', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $instruction_degree = new PayrollInstructionDegree;
        $instruction_degree->name  = $request->name;
        $instruction_degree->description = $request->description;
        $instruction_degree->save();
        return redirect()->route('instruction-degrees.index');
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
    public function edit(PayrollInstructionDegree $instruction_degree)
    {
        $header = [
            'route' => ['instruction-degrees.update', $instruction_degree], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::instruction-degrees.create-edit', compact('instruction_degree','header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollInstructionDegree $instruction_degree)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $instruction_degree->name  = $request->name;
        $instruction_degree->description = $request->description;
        $instruction_degree->save();
        return redirect()->route('instruction-degrees.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollInstructionDegree $instruction_degree)
    {
        if ($request->ajax())
        {
            $instruction_degree->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('instruction-degrees.index');
    }
}
