<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\Payroll;
use Modules\Payroll\Jobs\PayrollCreatePaymentRelationship;

/**
 * @class      PayrollController
 * @brief      Controlador de registros de nómina
 *
 * Clase que gestiona los registros de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author     Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.registers.list',   ['only' => ['index', 'vueList']]);
        //$this->middleware('permission:payroll.registers.create', ['only' => ['create', 'store']]);
        //$this->middleware('permission:payroll.registers.edit',   ['only' => ['edit', 'update']]);
        //$this->middleware('permission:payroll.registers.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'created_at'                => ['required'],
            'name'                      => ['required'],
            'payroll_payment_type_id'   => ['required'],
            'payroll_payment_period_id' => ['required'],
            'payroll_concepts'          => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'created_at.required'                => 'El campo fecha de generación es obligatorio.',
            'payroll_payment_type_id.required'   => 'El campo tipo de pago de nómina es obligatorio.',
            'payroll_payment_period_id.required' => 'El campo período de pago es obligatorio.',
            'payroll_concepts.required'          => 'El campo concepto es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de las nóminas de sueldos registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Renderable
     */
    public function index()
    {
        return view('payroll::registers.index');
    }

    /**
     * Muestra el formulario para registrar una nueva nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Renderable
     */
    public function create()
    {
        return view('payroll::registers.create-edit');
    }

    /**
     * Valida y registra una nueva nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        /**
         * FALTA:
         * 1-. validar payroll_parameters
         * Revisar regla de validación
         */
        $this->validate($request, $this->validateRules, $this->messages);
        PayrollCreatePaymentRelationship::dispatch($request->all());
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.registers.index')], 200);
    }

    /**
     * Muestra el formulario con la información de una nómina de sueldos registrada
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único del registro de nómina
     *
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function show($id)
    {
        /**
         * Objeto asociado al modelo Payroll
         * @var Object $payroll
         */
        $payroll = Payroll::find($id);
        return view('payroll::registers.show', compact('payroll'));
    }

    /**
     * Muestra el formulario para actualizar la información de una nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                  $id    Identificador único del registro de nómina
     *
     * @return    Renderable
     */
    public function edit($id)
    {
        /**
         * Objeto asociado al modelo Payroll
         * @var Object $payroll
         */
        $payroll = Payroll::find($id);
        return view('payroll::registers.create-edit', compact('payroll'));
    }

    /**
     * Actualiza la información de una nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único del registro de nómina
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        PayrollCreatePaymentRelationship::dispatch($request->all());

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['redirect' => route('payroll.registers.index')], 200);
    }

    /**
     * Elimina una nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único del registro de nómina
     *
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        /**
         * Objeto asociado al modelo Payroll
         * @var Object $payroll
         */
        $payroll = Payroll::find($id);
        $payroll->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene la información de una nómina de sueldos registrada
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único del registro de nómina
     *
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        /**
         * Objeto asociado al modelo Payroll
         * @var Object $payroll
         */
        $payroll = Payroll::with('payrollStaffPayrolls')->find($id);
        return response()->json(['record' => $payroll], 200);
    }

    /**
     * Obtiene un listado de los registros de nómina
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList()
    {
        return response()->json(['records' => Payroll::with(['payrollPaymentPeriod'])->get()], 200);
    }

    /**
     * Actualiza el estado de una nómina de sueldos
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único del registro de nómina
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function close(Request $request, $id)
    {
        $payroll = Payroll::find($id);
        $payrollPaymentPeriod = $payroll->payrollPaymentPeriod;
        $payrollPaymentPeriod->payment_status = 'generated';
        $payrollPaymentPeriod->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['redirect' => route('payroll.registers.index')], 200);
    }
}
