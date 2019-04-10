<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseInventaryRule;
use Modules\Warehouse\Models\WarehouseInventaryProduct;

/**
 * @class WarehouseInventaryController
 * @brief Controlador de las Reglas de los registros en inventario
 * 
 * Clase que gestiona los datos de las Reglas de los registros en inventario
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseInventaryRuleController extends Controller
{    
    use ValidatesRequests;
    
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.setting.rule');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => WarehouseInventaryRule::with(['inventary' =>
            function($query){
                $query->with('product');
            }])->get()], 200);

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'min' => 'required',
            'product_id' => 'required',
            'warehouse_id' => 'required',
        ]);
        $inventary = WarehouseInventaryProduct::where('warehouse_id',$request->warehouse_id)->where('product_id',$request->product_id)->where('unit_id',$request->unit_id)->get();

        $rule = WarehouseInventaryRule::create([
            'min' => $request->input('min'),
            'product_id' => $inventary->id,
        ]);

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
