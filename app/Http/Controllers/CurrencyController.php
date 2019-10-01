<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

/**
 * @class CurrencyController
 * @brief Gestiona información de Monedas
 *
 * Controlador para gestionar Monedas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CurrencyController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
            'name' => ['required', 'max:40'],
            'symbol' => ['required', 'max:4'],
            'country_id' => ['required'],
            'decimal_places' => ['required', 'numeric', 'min:2', 'max:10']
        ]);

        if ($request->default || !empty($request->default)) {
            /** Si se ha indicado la moneda por defecto, se deshabilita esta condición en las ya registradas */
            foreach (Currency::all() as $curr) {
                $curr->default = false;
                $curr->save();
            }
        }

        $currency = Currency::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'default' => ($request->default || !empty($request->default)),
            'country_id' => $request->country_id,
            'decimal_places' => $request->decimal_places
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
            'name' => ['required', 'max:40'],
            'symbol' => ['required', 'max:4'],
            'country_id' => ['required'],
            'decimal_places' => ['required', 'numeric', 'min:2', 'max:10']
        ]);

        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->country_id = $request->country_id;
        $currency->decimal_places = $request->decimal_places;
        if ($request->default) {
            /** Si se ha indicado la moneda por defecto, se deshabilita esta condición en las ya registradas */
            foreach (Currency::all() as $curr) {
                $curr->default = false;
                $curr->save();
            }

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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la moneda a buscar, este parámetro es opcional
     * @return \Illuminate\Http\JsonResponse        JSON con los datos de las monedas
     */
    public function getCurrencies($id = null)
    {
        return response()->json(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
    }

    /**
     * Obtiene información de una moneda
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la moneda de la cual se va a obtener información
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrencyInfo($id)
    {
        return response()->json(['result' => true, 'currency' => Currency::find($id)], 200);
    }
}
