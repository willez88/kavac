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
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CurrencyController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @method    __construct
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * Muesta todos los registros de las monedas.
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse    JSON con los datos de respuesta a la petición
     */
    public function index()
    {
        return response()->json(['records' => Currency::with('country')->get()], 200);
    }

    /**
     * Registra una nueva moneda
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con datos de la petición
     *
     * @return    JsonResponse     JSON con datos de respuesta a la petición
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

        /** @var Currency Objeto con información de la moneda registrada */
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
     * Actualiza un registro de moneda
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request     $request     Objeto con datos de la petición
     * @param     Currency    $currency    Objeto con información de la moneda a modificar
     *
     * @return    JsonResponse      JSON con información de respuesta a la petición
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

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina una moneda
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Currency    $currency    Objeto con información de la moneda a eliminar
     *
     * @return    JsonResponse      JSON con información de respuesta a la petición
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return response()->json(['record' => $currency, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las monedas registradas
     *
     * @method    getCurrencies
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Integer           $id    Identificador de la moneda a buscar, este parámetro es opcional
     *
     * @return    JsonResponse             JSON con los datos de las monedas
     */
    public function getCurrencies($id = null)
    {
        return response()->json(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
    }

    /**
     * Obtiene información de una moneda
     *
     * @method    getCurrencyInfo
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     integer             $id    Identificador de la moneda de la cual se va a obtener información
     *
     * @return    JsonResponse               JSON con datos de respuesta a la petición
     */
    public function getCurrencyInfo($id)
    {
        return response()->json(['result' => true, 'currency' => Currency::find($id)], 200);
    }
}
