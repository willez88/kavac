<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPaymentType;
use Modules\Payroll\Models\PayrollPaymentPeriod;
use Modules\Payroll\Models\PayrollConcept;

/**
 * @class      PayrollPaymentTypeController
 * @brief      Controlador de tipos de pago
 *
 * Clase que gestiona los tipos de pago
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollPaymentTypeController extends Controller
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
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.payment-types.list',   ['only' => 'index']);
        //$this->middleware('permission:payroll.payment-types.create', ['only' => 'store']);
        //$this->middleware('permission:payroll.payment-types.edit',   ['only' => 'update']);
        //$this->middleware('permission:payroll.payment-types.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'code'                  => ['required', 'unique:payroll_payment_types,code'],
            'name'                  => ['required'],
            'payment_periodicity'   => ['required'],
            'start_date'            => ['required'],
            'payment_relationship'  => ['required'],
            'payroll_concepts'      => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'code.required'                  => 'El campo código es obligatorio.',
            'payment_periodicity.required'   => 'El campo periodicidad de pago es obligatorio.',
            'start_date.required'            => 'El campo fecha de inicio del primer período es obligatorio.',
            'payment_relationship.required'  => 'El campo relación de pago es obligatorio.',
            'payroll_concepts.required'      => 'El campo conceptos es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de los tipos de pago
     *
     * @method    index
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        $listPaymentType = [];
        /**
         * Objeto asociado al modelo PayrollPaymentType
         * @var Object $payrollPaymentTypes
         */
        $payrollPaymentTypes = PayrollPaymentType::with(
            'payrollConcepts',
            'payrollPaymentPeriods'
        )->get();

        foreach ($payrollPaymentTypes as $payrollPaymentType) {
            $listConcepts = [];
            foreach ($payrollPaymentType->payrollConcepts as $payrollConcept) {
                array_push(
                    $listConcepts,
                    [
                        'id' => $payrollConcept->id,
                        'text' => $payrollConcept->code . ' - ' . $payrollConcept->name
                    ]
                );
            }
            $associated_records = json_decode($payrollPaymentType->associated_records);
            array_push(
                $listPaymentType,
                [
                    'id'                    => $payrollPaymentType->id,
                    'code'                  => $payrollPaymentType->code,
                    'name'                  => $payrollPaymentType->name,
                    'payment_periodicity'   => $payrollPaymentType->payment_periodicity,
                    'periods_number'        => '',
                    'correlative'           => $payrollPaymentType->correlative,
                    'start_date'            => $payrollPaymentType->start_date,
                    'payment_relationship'  => $payrollPaymentType->payment_relationship,
                    'associated_records'    => json_decode($payrollPaymentType->associated_records),
                    'payroll_concepts'      => $listConcepts,
                    'payroll_payment_periods' => $payrollPaymentType->payrollPaymentPeriods
                ]
            );
        }
        return response()->json(['records' => json_decode(json_encode($listPaymentType))], 200);
    }

    /**
     * Valida y registra un nuevo tipo de pago
     *
     * @method    store
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        /**
         * Objeto asociado al modelo PayrollPaymentType
         * @var Object $payrollPaymentType
         */
        $payrollPaymentType = PayrollPaymentType::create([
            'code'                  => $request->code,
            'name'                  => $request->name,
            'payment_periodicity'   => $request->payment_periodicity,
            'correlative'           => !empty($request->correlative)
                                           ? $request->correlative
                                           : false,
            'start_date'            => $request->start_date,
            'payment_relationship'  => $request->payment_relationship,
            'associated_records'    => json_encode($request->associated_records)
        ]);
        /** Se agregan los conceptos asociados al tipo de pago a la tabla pivote */
        foreach ($request->payroll_concepts as $payrollConcept) {
            if ($payrollConcept['id'] != '') {
                $concept = PayrollConcept::find($payrollConcept['id']);
                $payrollPaymentType->payrollConcepts()->attach($concept);
            }
        }
        /** Se agregan los períodos de pago asociados al tipo de pago */
        foreach ($request->payroll_payment_periods as $paymentPeriod) {
            $payrollPaymentPeriod = PayrollPaymentPeriod::create([
                'number'                  => $paymentPeriod['number'],
                'start_date'              => $paymentPeriod['start_date'],
                'start_day'               => $paymentPeriod['start_day'],
                'end_date'                => $paymentPeriod['end_date'],
                'end_day'                 => $paymentPeriod['end_day'],
                'payment_status'          => $paymentPeriod['payment_status'],
                'payroll_payment_type_id' => $payrollPaymentType->id
            ]);
        }
        return response()->json(['record' => $payrollPaymentType, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de un tipo de pago
     *
     * @method    update
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto con la información del tipo de pago a editar asociado al modelo PayrollPaymentType
         * @var Object $payrollPaymentType
         */
        $payrollPaymentType = PayrollPaymentType::find($id);
        $validateRules = $this->validateRules;
        $validateRules = array_replace(
            $validateRules,
            ['code' => ['required', 'unique:payroll_payment_types,code,' . $payrollPaymentType->id]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $payrollPaymentType->code                  = $request->code;
        $payrollPaymentType->name                  = $request->name;
        $payrollPaymentType->payment_periodicity   = $request->payment_periodicity;
        $payrollPaymentType->correlative           = !empty($request->correlative)
                                                         ? $request->correlative
                                                         : $payrollPaymentType->correlative;
        $payrollPaymentType->start_date            = $request->start_date;
        $payrollPaymentType->payment_relationship  = $request->payment_relationship;
        $payrollPaymentType->associated_records    = json_encode($request->associated_records);
        $payrollPaymentType->save();

        /** Se eliminan los conceptos asociados al tipo de pago de la tabla pivote */
        foreach ($payrollPaymentType->payrollConcepts as $payrollConcept) {
            $concept = PayrollConcept::find($payrollConcept['id']);
            $payrollPaymentType->payrollConcepts()->detach($concept);
        }
        /** Se agregan los nuevos conceptos asociados al tipo de pago a la tabla pivote */
        foreach ($request->payroll_concepts as $payrollConcept) {
            if ($payrollConcept['id'] != '') {
                $concept = PayrollConcept::find($payrollConcept['id']);
                $payrollPaymentType->payrollConcepts()->attach($concept);
            }
        }

        /** Se eliminan los períodos de pago asociados al tipo de pago */
        foreach ($payrollPaymentType->payrollPaymentPeriods as $payrollPaymentPeriod) {
            $payrollPaymentPeriod->forceDelete();
            ;
        }
        /** Se agregan los períodos de pago asociados al tipo de pago */
        foreach ($request->payroll_payment_periods as $paymentPeriod) {
            /**
             * Objeto asociado al modelo PayrollPaymentPeriod
             * @var Object $payrollPaymentPeriod
             */
            $payrollPaymentPeriod = PayrollPaymentPeriod::create([
                'number'                  => $paymentPeriod['number'],
                'start_date'              => $paymentPeriod['start_date'],
                'start_day'               => $paymentPeriod['start_day'],
                'end_date'                => $paymentPeriod['end_date'],
                'end_day'                 => $paymentPeriod['end_day'],
                'payment_status'          => $paymentPeriod['payment_status'],
                'payroll_payment_type_id' => $payrollPaymentType->id
            ]);
        }
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un tipo de pago
     *
     * @method    destroy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único del tipo de pago a eliminar
     *
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        /**
         * Objeto con la información del tipo de pago a eliminar asociado al modelo PayrollPaymentType
         * @var Object $payrollPaymentType
         */
        $payrollPaymentType = PayrollPaymentType::find($id);
        $payrollPaymentType->delete();
        return response()->json(['record' => $payrollPaymentType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de pago registrados
     *
     * @method    getPayrollPaymentTypes
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Array    Listado de los registros a mostrar
     */
    public function getPayrollPaymentTypes()
    {
        return template_choices('Modules\Payroll\Models\PayrollPaymentType', ['code', '-', 'name'], '', true);
    }

    /**
     * Obtiene los períodos asociados al tipo de pago registrado
     *
     * @method    getPayrollPaymentPeriods
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer    $payment_type_id    Identificador único asociado al tipo de pago
     *
     * @return    Array                          Listado de los registros a mostrar
     */
    public function getPayrollPaymentPeriods($payment_type_id = null)
    {
        $listPayrollPaymentPeriods = [];
        $listPayrollConcepts = [];
        $payrollPaymentType = PayrollPaymentType::find($payment_type_id);
        foreach ($payrollPaymentType->payrollConcepts as $payrollConcept) {
            array_push($listPayrollConcepts, [
                    'id'             => $payrollConcept->id,
                    'text'           => $payrollConcept->code . ' - ' . $payrollConcept->name
                ]);
        }
        $payrollPaymentPeriods = PayrollPaymentPeriod::where(
            'payroll_payment_type_id',
            $payrollPaymentType->id
        )->orderBy('number')->get();

        if (!is_null($payrollPaymentPeriods)) {
            foreach ($payrollPaymentPeriods as $payrollPaymentPeriod) {
                array_push($listPayrollPaymentPeriods, [
                    'id'             => $payrollPaymentPeriod->id,
                    'text'           => date("d/m/Y", strtotime($payrollPaymentPeriod->start_date)),
                    'payment_status' => $payrollPaymentPeriod->payment_status
                ]);
            }
            return response()->json([
                'records' => $listPayrollPaymentPeriods, 'concepts' => $listPayrollConcepts
            ], 200);
        }
    }
}
