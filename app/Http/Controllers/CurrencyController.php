<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:currency.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:currency.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:currency.delete', ['only' => 'destroy']);
        $this->middleware('permission:currency.list', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Currency::with('country')->get()], 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
            'symbol' => 'required|max:4',
            'country_id' => 'required'
        ]);


        $currency = Currency::create([
            'name' => $request->input('name'),
            'symbol' => $request->input('symbol'),
            'default' => ($request->input('default') || !empty($request->input('default'))),
            'country_id' => $request->input('country_id')
        ]);

        return response()->json(['record' => $currency, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Currency $currency)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
            'symbol' => 'required|max:4',
            'country_id' => 'required'
        ]);
 
        $currency->name = $request->input('name');
        $currency->symbol = $request->input('symbol');
        $currency->country_id = $request->country_id;
        if ($request->default) {
            $currency->default = $request->default;
        }
        $currency->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return response()->json(['record' => $currency, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las monedas registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la moneda a buscar, este parámetro es opcional
     * @return JSON        JSON con los datos de las monedas
     */
    public function getCurrencies($id = null)
    {
        $data = [];
        $currencies = ($id) ? Currency::where('id', $id)->get() : Currency::all();
        foreach ($currencies as $currency) {
            array_push($data, [
                'id' => $currency->id,
                'text' => $currency->symbol . " - " . $currency->name
            ]);
        }

        return response()->json($data);
    }
}
