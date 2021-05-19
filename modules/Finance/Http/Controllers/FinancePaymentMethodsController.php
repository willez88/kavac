<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinancePaymentMethods;

/**
 * @class FinanceAccountTypeController
 * @brief Controlador para los tipos de cuenta bancaria
 *
 * Clase que gestiona las formas de pago
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * --colaborador  Ing. Marco Ocanto 
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class FinancePaymentMethodsController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => FinancePaymentMethods::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:finance_payment_methods,name'],
            'description' => ['required', 'max:100', 'unique:finance_payment_methods,description'],
        ]);

        $financePaymentMethods = FinancePaymentMethods::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['record' => $financePaymentMethods, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var object Datos del tipo de pago */
        $financePaymentMethods = FinancePaymentMethods::find($id);

        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:finance_payment_methods,name,' . $financePaymentMethods->id],
            'description' => ['required', 'max:100', 'unique:finance_payment_methods,description,' . $financePaymentMethods->id],
        ]);

        $financePaymentMethods->name = $request->name;
        $financePaymentMethods->description = $request->description;
        $financePaymentMethods->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var object Datos del tipo de pago */
        $financePaymentMethods = FinancePaymentMethods::find($id);
        $financePaymentMethods->delete();
        return response()->json(['record' => $financePaymentMethods, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de pagos
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse Devuelve un JSON con los datos de los tipos de cuenta bancaria
     */
    public function getPaymentMethods()
    {
        foreach (FinancePaymentMethods::all() as $payment_methods) {
            $this->data[] = [
                'id' => $payment_methods->id,
                'text' => $payment_methods->name,
                'description' => $payment_methods->description,
            ];
        }

        return response()->json($this->data);
    }
}
