<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\Warehouse;
use App\Models\Institution;

/**
 * @class WarehouseReportController
 * @brief Controlador de los reportes de productos registrados en almacén
 *
 * Clase que gestiona los reportes de productos registrados en almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseReportController extends Controller
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
        $this->middleware('permission:warehouse.report.create', ['only' => 'create']);
    }

    /**
     * Muestra un listado de los reportes generados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('warehouse::reports.create');
    }

    public function create()
    {
        return view('warehouse::reports.warehouse_report_products');
    }

    public function vueListProduct($type, $id = null)
    {
        $field = ($type == 'product')? WarehouseProduct::find($id):Warehouse::find($id);
        
        if (is_null($field)) {
            $warehouse_product = WarehouseInventoryProduct::with(
                [
                    'currency',
                    'warehouseProduct',
                    'warehouseInventoryRule',
                    'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    },
                    'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    },
                ]
            )->orderBy('warehouse_product_id')->get();
        } elseif ($type == 'product') {
            $warehouse_product = WarehouseInventoryProduct::where('warehouse_product_id', $field->id)->with(
                [
                    'currency',
                    'warehouseProduct',
                    'warehouseInventoryRule',
                    'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    },
                    'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    },
                ]
            )->orderBy('warehouse_institution_warehouse_id')->get();
        } else {
            $warehouse_product = WarehouseInventoryProduct::where('warehouse_institution_warehouse_id', $field->id)
                ->with(
                    [
                        'currency',
                        'warehouseProduct',
                        'warehouseInventoryRule',
                        'warehouseProductValues' => function ($query) {
                            $query->with('warehouseProductAttribute');
                        },
                        'warehouseInstitutionWarehouse' => function ($query) {
                            $query->with('warehouse');
                        },
                    ]
                )->orderBy('warehouse_product_id')->get();
        }
        return response()->json(['records' => $warehouse_product], 200);
    }

    public function vueList($product_id, $warehouse_id)
    {
        $product = WarehouseProduct::find($product_id);
        $institution = Institution::where('active', true)->where('default', true)->first();
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $warehouse_id)
                    ->where('institution_id', $institution->id)->first();

        if ((!is_null($product)) && (!is_null($inst_ware))) {
            $warehouse_product = WarehouseInventoryProduct::where('warehouse_institution_warehouse_id', $inst_ware->id)
                ->where('warehouse_product_id', $product->id)
                ->with(['warehouseProduct' => function ($query) {
                    $query->with(['warehouseProductAttributes' => function ($query) {
                        $query->with('warehouseProductValue');
                    }
                        ]);
                }, 'warehouseInstitutionWarehouse' => function ($query) {
                    $query->with('warehouse');
                },'warehouseInventoryRule'])->orderBy('warehouse_product_id')
                ->orderBy('warehouse_institution_warehouse_id')->get();
        }

        return response()->json(['records' => ($warehouse_product)?$warehouse_product:null], 200);
    }
}
