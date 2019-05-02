<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseInventaryRule;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Illuminate\Support\Facades\Auth;

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
     * Muestra un listado de las Reglas de Inventario Registradas
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => WarehouseInventaryRule::with(['inventary' =>
            function($query){
                $query->with('product');
            }])->get()], 200);

    }

    /**
     * Valida y registra una Regla de Inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'min' => 'required',
        ]);

        $rule = WarehouseInventaryRule::create([
            'min' => $request->min,
            'inventary_id' => $request->id,
            'user_id' => Auth::id(),
        ]);
        return response()->json(['result' => true],200);
    }
    /**
     * Actualiza la información de una Regla de Inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id (Identificador único del producto en inventario)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'min' => 'required',
        ]);
        
        $rule = WarehouseInventaryRule::where('inventary_id', $id)->first();
        $rule->min = $request->min;
        $rule->save();

        return response()->json(['result' => true],200);
    }

    public function vueList($warehouse = null, $institution = null)
    {
        if(is_null($warehouse)||is_null($institution)){
            $warehouse_product = WarehouseInventaryProduct::with(['product'=>
                    function($query){
                        $query->with(['attributes'=>
                            function($query){
                                $query->with('value');
                            }]);
                    },'warehouseInstitution' =>
                        function($query){
                            $query->with('warehouse');
                        },'rule'])->get();
        }
        else{
            $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id',$warehouse)->where('institution_id', $institution)->first();

            if($inst_ware){
                $warehouse_product = WarehouseInventaryProduct::where('warehouse_institution_id',$inst_ware->id)
                    ->with(['product'=>
                        function($query){
                            $query->with(['attributes'=>
                                function($query){
                                    $query->with('value');
                                }]);
                        },'warehouseInstitution' =>
                            function($query){
                                $query->with('warehouse');
                            },'rule'])->get();
            }
        }

        return response()->json(['records' => $warehouse_product], 200);
    }


}
