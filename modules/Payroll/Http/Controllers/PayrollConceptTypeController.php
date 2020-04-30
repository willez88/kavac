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
        return response()->json(['records' => PayrollConceptType::all()], 200);
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
        
        $payrollConceptType = PayrollConceptType::create([
            'name'        => $request->name,
            'description' => $request->description,
            'sign'        => $request->sign
        ]);
        return response()->json(['record' => $payrollConceptType, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(PayrollConceptType $concept_type)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $payrollConceptType = PayrollConceptType::find($id);
        $this->validate($request, [
            'name'        => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
            'sign'        => ['required', 'max:1']
        ]);
        $payrollConceptType->name  = $request->name;
        $payrollConceptType->description = $request->description;
        $payrollConceptType->sign = $request->sign;
        $payrollConceptType->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $payrollConceptType = PayrollConceptType::find($id);
        $payrollConceptType->delete();
        return response()->json(['record' => $payrollConceptType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de conceptos registrados
     *
     * @return Array Listado de los registros a mostrar
     */
    public function getPayrollConceptTypes()
    {
        return template_choices('Modules\Payroll\Models\PayrollConceptType', ['name'], '', true);
    }
}
