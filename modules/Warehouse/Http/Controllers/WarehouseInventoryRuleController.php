<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseInventoryRule;

/**
 * @class WarehouseInventoryController
 * @brief Controlador de las reglas de abastecimiento del inventario
 *
 * Clase que gestiona los datos de las reglas de abastecimiento del inventario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseInventoryRuleController extends Controller
{
    use ValidatesRequests;
    
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.setting.rule');
    }

    /**
     * Muestra un listado de las reglas de abastecimiento del inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $warehouse_product = WarehouseInventoryProduct::with(
            ['currency', 'warehouseProductValues' => function ($query) {
                $query->with('warehouseProductAttribute');
            }, 'warehouseProduct', 'warehouseInstitutionWarehouse' => function ($query) {
                $query->with('warehouse');
            }, 'warehouseInventoryRule']
        )->get();

        return response()->json(['records' => $warehouse_product], 200);
    }

    /**
     * Valida y registra una regla de de abastecimiento del inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'minimum' => 'required',
            'warehouse_inventory_product_id' => 'required',
        ]);

        $rule = WarehouseInventoryRule::create([
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'warehouse_inventory_product_id' => $request->warehouse_inventory_product_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una regla de abastecimiento del inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id (Identificador único del producto en inventario)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, WarehouseInventoryRule $rule)
    {
        $this->validate($request, [
            'minimum' => 'required',
        ]);
        
        $rule->minimum = $request->minimum;
        $rule->maximum = $request->maximum;
        $rule->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina una regla de inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del registro
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $rule = WarehouseInventoryRule::where('warehouse_inventory_product_id', $id)->first();
        if (!is_null($rule)) {
            $rule->delete();
        }
        return response()->json(['record' => $rule, 'message' => 'Success'], 200);
    }

    public function vueList($warehouse = null, $institution = null)
    {
        if (is_null($warehouse) || is_null($institution)) {
            $warehouse_product = WarehouseInventoryProduct::with(
                ['currency', 'warehouseProductValues' => function ($query) {
                    $query->with('warehouseProductAttribute');
                }, 'warehouseProduct', 'warehouseInstitutionWarehouse' => function ($query) {
                    $query->with('warehouse');
                }, 'warehouseInventoryRule']
            )->get();
        } else {
            $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $warehouse)
                ->where('institution_id', $institution)->first();

            if ($inst_ware) {
                $warehouse_product = WarehouseInventoryProduct::where(
                    'warehouse_institution_warehouse_id',
                    $inst_ware->id
                )
                    ->with(['currency', 'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    }, 'warehouseProduct', 'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    },'warehouseInventoryRule'])->get();
            }
        }

        return response()->json(['records' => $warehouse_product], 200);
    }
}
