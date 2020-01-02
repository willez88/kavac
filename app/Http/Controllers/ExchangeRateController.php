<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    /**
     * Define la configuración de la clase
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => ExchangeRate::with('fromCurrency', 'toCurrency')->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        $exchangeRate = ExchangeRate::create($request->all());

        return response()->json(['record' => $exchangeRate, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function show(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate->delete();
        return response()->json(['record' => $exchangeRate, 'message' => 'Success'], 200);
    }
}
