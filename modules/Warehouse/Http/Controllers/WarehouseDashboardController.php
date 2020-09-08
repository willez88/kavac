<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Warehouse\Models\WarehouseMovement;
use Modules\Warehouse\Models\WarehouseRequest;
use Modules\Warehouse\Models\WarehouseInventoryProduct;

class WarehouseDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('warehouse::dashboard');
    }

    public function getOperation($type_operation, $code)
    {
        return response()->json(['result' => true, 'redirect' => '/warehouse/reports/show/'.$code], 200);
    }

    public function vueListOperations()
    {
        $tables = ['warehouse_movements', 'warehouse_requests'];
        $fields = [];

        foreach ($tables as $table) {
            if ($table == 'warehouse_movements') {
                $type_operation = 'movements';
                $data_operations = \DB::table($table)
                 ->select('code', 'created_at', 'description')
                 ->get();
            } elseif ($table == 'warehouse_requests') {
                $type_operation = 'requests';
                $data_operations = \DB::table($table)
                 ->select('code', 'created_at')
                 ->get();
            }
            foreach ($data_operations as $data) {
                array_push($fields, [
                    'code' => $data->code,
                    'type_operation' => $type_operation,
                    'description' => ($type_operation == 'movements')?
                        $data->description:'Solicitud de productos al almacén',
                    'created_at' => $data->created_at,
                ]);
            }
        }
        return response()->json(['records' => $fields]);
    }

    public function vueInfo($type_operation, $code)
    {
        if ($type_operation == 'movements') {
            $field = WarehouseMovement::where('code', $code)
                ->with(
                    ['warehouseInventoryProductMovements' => function ($query) {
                        $query->with(['warehouseInventoryProduct' => function ($query) {
                            $query->with(['warehouseProduct' => function ($query) {
                                $query->with('measurementUnit');
                            }, 'warehouseProductValues' => function ($query) {
                                $query->with('warehouseProductAttribute');
                            }, 'currency']);
                        }]);
                    }]
                )->first();
            return response()->json(['records' => $field->warehouseInventoryProductMovements], 200);
        } elseif ($type_operation == 'requests') {
            $field = WarehouseRequest::where('code', $code)
                ->with(
                    [
                        'warehouseInventoryProductRequests' => function ($query) {
                            $query->with(['warehouseInventoryProduct' => function ($query) {
                                $query->with(['warehouseProduct' => function ($query) {
                                    $query->with('measurementUnit');
                                }, 'currency']);
                            }]);
                        }
                    ]
                )->first();
            return response()->json(['records' => $field->warehouseInventoryProductRequests], 200);
        } else {
            return response()->json(['records' => [] ], 200);
        }
    }

    public function vueListMinProducts()
    {
        $fields = WarehouseInventoryProduct::with(
            [
                'warehouseProduct' => function ($query) {
                    $query->with('measurementUnit');
                },
                'warehouseProductValues' => function ($query) {
                    $query->with('warehouseProductAttribute');
                },
                'warehouseInventoryRule',
                'currency',
                'warehouseInstitutionWarehouse' => function ($query) {
                    $query->with('warehouse', 'institution');
                },
            ]
        )
        ->get();
        $warehouse_products = [];
        foreach ($fields as $field) {
            $minimum = ($field->warehouseInventoryRule == null)?0:$field->warehouseInventoryRule->minimum;
            $exist_teorica = ($field->exist > 0)?$field->exist - $minimum:0;
            $product_free = $exist_teorica - $field->reserved;
            $product_free = ($exist_teorica > 0)?$product_free * 100 / ($exist_teorica):0;

            $warehouse_product = [
                'code' => $field->code,
                'exist' => ($field->exist != 0)?$field->exist:0,
                'reserved' => $field->reserved,
                'free' => $product_free,
                'currency' => $field->currency,
                'unit_value' => $field->unit_value,
                'measurement_unit' => ($field->warehouseProduct->measurement_unit_id != null)
                    ? $field->warehouseProduct->measurementUnit
                    : null,
                'warehouse_product' => $field->warehouseProduct,
                'warehouse_product_values' => $field->warehouseProductValues,
                'warehouse_institution_warehouse' => $field->warehouseInstitutionWarehouse,
            ];
            array_push($warehouse_products, $warehouse_product);
        }
        return response()->json(['records' => $warehouse_products]);
    }
}
