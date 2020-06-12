<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollPaymentType;

/**
 * @class      PayrollPaymentTypeController
 * @brief      Controlador de tipos de pago
 *
 * Clase que gestiona los tipos de pago
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollPaymentTypeController extends Controller
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
            'code'                  => ['required'],
            'name'                  => ['required'],
            'payment_periodicity'   => ['required'],
            'start_date'            => ['required'],
            'payment_relationship'  => ['required'],
            'accounting_account_id' => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'code.required'                  => 'El campo código es obligatorio.',
            'payment_periodicity.required'   => 'El campo periodicidad de pago es obligatorio.',
            'start_date.required'            => 'El campo fecha de inicio del primer período es obligatorio.',
            'payment_relationship.required'  => 'El campo relación de pago es obligatorio.',
            'accounting_account_id.required' => 'El campo cuenta contable es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de los tipos de pago
     *
     * @method    index
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollPaymentType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo de pago
     *
     * @method    store
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request     $request    Datos de la petición
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);
        return response()->json(['message' => 'Success'], 200);

        /**
         * Objeto asociado al modelo PayrollPaymentType
         *
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
            'accounting_account_id' => $request->accounting_account_id
        ]);
        return response()->json(['record' => $payrollPaymentType, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de un tipo de pago
     *
     * @method    update
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Success'], 200);
        /**
         * Objeto con la información del tipo de pago a editar asociado al modelo PayrollPaymentType
         *
         * @var Object $payrollPaymentType
         */
        $payrollPaymentType = PayrollPaymentType::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $payrollPaymentType->code                  = $request->code;
        $payrollPaymentType->name                  = $request->name;
        $payrollPaymentType->payment_periodicity   = $request->payment_periodicity;
        $payrollPaymentType->correlative           = !empty($request->correlative)
                                                       ? $request->correlative
                                                       : $payrollPaymentType->correlative;
        $payrollPaymentType->start_date            = $request->start_date;
        $payrollPaymentType->payment_relationship  = $request->payment_relationship;
        $payrollPaymentType->accounting_account_id = $request->accounting_account_id;
        $payrollPaymentType->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un tipo de pago
     *
     * @method    destroy
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer $id                      Identificador único del tipo de pago a eliminar
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        /**
         * Objeto con la información del tipo de pago a eliminar asociado al modelo PayrollPaymentType
         *
         * @var Object $payrollPaymentType
         */
        $payrollPaymentType = PayrollPaymentType::find($id);
        $payrollPaymentType->delete();
        return response()->json(['record' => $payrollPaymentType, 'message' => 'Success'], 200);
    }
}
