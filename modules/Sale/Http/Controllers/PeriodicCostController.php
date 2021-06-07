<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\PeriodicCostAttribute;
use Modules\Sale\Models\PeriodicCost;

/**
 * @class PeriodicCostController
 * @brief Gestiona información de Costos fijos
 *
 * [PeriodicCost: Costos Fijos]
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PeriodicCostController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador */
        /*
        $this->middleware('permission:sale.setting.periodic.cost.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:sale.setting.periodic.cost.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.setting.periodic.cost.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.setting.periodic.cost.delete', ['only' => 'destroy']);
        */
    }
    /**
     * Muesta todos los registros de Costos fijos
     *
     * @method    index
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse con los registros de Periodos de tiempo
     */
    public function index()
    {
        return response()->json(['records' => PeriodicCost::with(['Currency', 'Frecuency', 'PeriodicCostAttribute'])->get()], 200);
    }

    /**
     * Valida y registra un nuevo Costo fijo
     *
     * @method    store
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function store(Request $request)
    {
        $this->periodicCostValidate($request);
        $attributes = !empty($request->attributes)? $request->input('attributes') : false;
        $inputs = [];
        $fields = ['name', 'description', 'value', 'currency_id', 'frecuency_id', 'attributes'];
        foreach ($fields as $id) {
          if ($id != 'attributes') {
            $inputs[$id] = $request->input($id);
          }
          else {
            $inputs[$id] = !empty($request->{$id})? $request->input($id) : false;
          }
        }
        $PeriodicCost = PeriodicCost::create($inputs);
        $attributes = $inputs['attributes']? $request->periodic_cost_attribute : [];
        $this->createAttributes($attributes, $PeriodicCost->id);
        return response()->json(['record' => $PeriodicCost, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del costo fijo
     *
     * @method    update
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     Modules\Sale\Models\PeriodicCost   $PeriodicCost    Registro con el costo fijo
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function update(Request $request, PeriodicCost $PeriodicCost)
    {
        $this->periodicCostValidate($request);
        $fields = ['name', 'description', 'value', 'currency_id', 'frecuency_id', 'attributes'];
        foreach ($fields as $id) {
          if ($id != 'attributes') {
            $PeriodicCost->{$id} = $request->input($id);
          }
          else {
            $PeriodicCost->{$id} = !empty($request->{$id})? $request->input($id) : false;
          }
        }
        $PeriodicCost->save();
        $attributes = !empty($request->attributes)? $request->periodic_cost_attribute : [];
        $this->createAttributes($attributes, $PeriodicCost->id);
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    destroy
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  Modules\Sale\Models\PeriodicCost   $PeriodicCost    Registro con el costo fijo
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function destroy(PeriodicCost $PeriodicCost)
    {
        $this->createAttributes([], $PeriodicCost->id);
        $PeriodicCost->delete();
        return response()->json(['record' => $PeriodicCost, 'message' => 'Success'], 200);
    }

    /**
     * Realiza la validación de un costo fijo
     *
     * @method    periodicCostValidate
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     object    Request    $request         Objeto con datos de la petición
     */
    public function periodicCostValidate(Request $request)
    {
        $validation = [];
        $validation['name'] = ['required', 'max:60'];
        $validation['description'] = ['required'];
        $validation['value'] = ['required', 'numeric', 'gt:0'];
        $validation['currency_id'] = ['required'];
        $validation['frecuency_id'] = ['required'];
        if (!empty($request->attributes)) {
            $validation['periodic_cost_attribute.*'] = ['required', 'max:100'];
        }
        $this->validate($request, $validation);
    }

    /**
     * Agrega atributos a un costo fijo
     *
     * @method    createAttributes
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     array    $attributes         Arreglo con los atributos a agregar
     * @param     integer   $id        Identificador del Costo fijo
     */
    public function createAttributes($attributes = [], $id = 0)
    {
        if ($id) {
            PeriodicCostAttribute::where('periodic_cost_id', $id)->delete();
            foreach ($attributes as $att) {
                $attribute = PeriodicCostAttribute::create([
                    'name' => $att['name'],
                    'periodic_cost_id' => $id
                ]);
            }
        }
    }

    /**
     * Muestra una lista de los atributos de un costo fijo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     integer   $periodic_cost_id        Identificador del Costo fijo
     * @return \Illuminate\Http\JsonResponse con los atributos del costo fijo
     */
    public function getPeriodicCostAttributes($periodic_cost_id)
    {
        return response()->json([
            'records' => PeriodicCostAttribute::with('PeriodicCost')->where(
                'periodic_cost_id',
                $periodic_cost_id
            )->get()
        ]);
    }
}
