<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollConceptType;

/**
 * @class PayrollConceptTypeController
 * @brief Controlador de tipo de concepto
 *
 * Clase que gestiona los tipos de concepto
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollConceptTypeController extends Controller
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
        $this->middleware('permission:payroll.concept.types.list', ['only' => 'index']);
        $this->middleware('permission:payroll.concept.types.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.concept.types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.concept.types.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $concept_types = PayrollConceptType::all();
        return view('payroll::concept-types.index', compact('concept_types'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'payroll.concept-types.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::concept-types.create-edit', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
            'sign' => ['required', 'max:1']
        ]);
        $concept_type = new PayrollConceptType;
        $concept_type->name  = $request->name;
        $concept_type->description = $request->description;
        $concept_type->sign = $request->sign;
        $concept_type->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('payroll.concept-types.index');
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
    public function edit(PayrollConceptType $concept_type)
    {
        $header = [
            'route' => ['payroll.concept-types.update', $concept_type], 'method' => 'PUT',
            'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::concept-types.create-edit', compact('concept_type', 'header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollConceptType $concept_type)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
            'sign' => ['required', 'max:1']
        ]);
        $concept_type->name  = $request->name;
        $concept_type->description = $request->description;
        $concept_type->sign = $request->sign;
        $concept_type->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('payroll.concept-types.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollConceptType $concept_type)
    {
        if ($request->ajax()) {
            $concept_type->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('payroll.concept-types.index');
    }
}
