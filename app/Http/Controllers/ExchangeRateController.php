<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

/**
 * @class ExchangeRateController
 * @brief Gestiona información de tipos de cambio de monedas
 *
 * Controlador para gestionar tipos de cambio de monedas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ExchangeRateController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @method  __construct
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:exchange.rate.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:exchange.rate.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:exchange.rate.delete', ['only' => 'destroy']);
        $this->middleware('permission:exchange.rate.list', ['only' => 'index']);
    }

    /**
     * Listado de tipos de cambio de monedas
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse      JSON con datos de los tipos de cambio de monedas registrados
     */
    public function index()
    {
        return response()->json(['records' => ExchangeRate::with('fromCurrency', 'toCurrency')->get()], 200);
    }

    /**
     * Registra un nuevo tipo de cambio de moneda
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse      JSON con datos de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date'],
            'amount' => ['required', 'numeric'],
            'from_currency_id' => ['required'],
            'to_currency_id' => ['required']
        ], [
            'start_at.required' => __('La fecha de inicio es requerida'),
            'start_at.date' => __('La fecha de inicio es inválida'),
            'end_at.date' => __('La fecha final es inválida'),
            'from_currency_id.required' => __('La moneda desde la cual realizar la conversión es requerida'),
            'to_currency_id.required' => __('La moneda a la cual realizar la conversión es requerida'),
            'amount.required' => __('El monto de conversión es requerido'),
            'amount.numeric' => __('El monto de conversión debe ser numérico'),
        ]);

        /** @var ExchangeRate Objeto con información del tipo de cambio creado */
        $exchangeRate = ExchangeRate::create($request->all());

        return response()->json(['record' => $exchangeRate, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza los datos de un tipo de cambio de moneda
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request         $request         Objeto con información de la petición
     * @param     ExchangeRate    $exchangeRate    Objeto con información del tipo de cambio a actualizar
     *
     * @return    JsonResponse      JSON con datos de respuesta a la petición
     */
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        $this->validate($request, [
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date'],
            'amount' => ['required', 'numeric'],
            'from_currency_id' => ['required'],
            'to_currency_id' => ['required']
        ], [
            'start_at.required' => __('La fecha de inicio es requerida'),
            'start_at.date' => __('La fecha de inicio es inválida'),
            'end_at.date' => __('La fecha final es inválida'),
            'from_currency_id.required' => __('La moneda desde la cual realizar la conversión es requerida'),
            'to_currency_id.required' => __('La moneda a la cual realizar la conversión es requerida'),
            'amount.required' => __('El monto de conversión es requerido'),
            'amount.numeric' => __('El monto de conversión debe ser numérico'),
        ]);

        $exchangeRate->update($request->all());
        return response()->json(['record' => $exchangeRate, 'message' => 'Update'], 200);
    }

    /**
     * Elimina un tipo de cambio de moneda
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     ExchangeRate    $exchangeRate    Objeto con información del tipo de cambio a eliminar
     *
     * @return    JsonResponse      JSON con datos del tipo de cambio eliminado
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate->delete();
        return response()->json(['record' => $exchangeRate, 'message' => 'Success'], 200);
    }
}
