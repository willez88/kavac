<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollConceptType;

/**
 * @class      PayrollConceptTypeController
 * @brief      Controlador de tipo de concepto
 *
 * Clase que gestiona los tipos de concepto
 *
 * @author     William Páez <wpaez at cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollConceptTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     *
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     *
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.concept.types.list', ['only' => 'index']);
        $this->middleware('permission:payroll.concept.types.create', ['only' => ['store']]);
        $this->middleware('permission:payroll.concept.types.edit', ['only' => ['update']]);
        $this->middleware('permission:payroll.concept.types.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'        => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
            'sign'        => ['required', 'max:1']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'sign.required' => 'El campo signo es obligatorio.',
            'sign.max:1'    => 'El campo signo no debe ser mayor de 1 carácter.',
        ];
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PayrollConceptType::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        /**
         * Objeto asociado al modelo PayrollConceptType
         *
         * @var Object $payrollConceptType
         */
        $payrollConceptType = PayrollConceptType::create([
            'name'        => $request->name,
            'description' => $request->description,
            'sign'        => $request->sign
        ]);
        return response()->json(['record' => $payrollConceptType, 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto con la información del tipo de pago a editar asociado al modelo PayrollConceptType
         *
         * @var Object $payrollConceptType
         */
        $payrollConceptType = PayrollConceptType::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $payrollConceptType->name  = $request->name;
        $payrollConceptType->description = $request->description;
        $payrollConceptType->sign = $request->sign;
        $payrollConceptType->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /**
         * Objeto con la información del tipo de pago a eliminar asociado al modelo PayrollConceptType
         *
         * @var Object $payrollConceptType
         */
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
