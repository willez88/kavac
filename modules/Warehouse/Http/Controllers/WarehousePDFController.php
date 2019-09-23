<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Routing\Controller;

use Modules\Warehouse\Models\Warehouse;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use App\Models\Institution;
use App\Models\Parameter;

use Modules\Warehouse\Pdf\Pdf;

/**
 * @class WarehousePDFController
 * @brief Controlador de los atributos de los productos de almacén
 *
 * Clase que gestiona los atributos de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehousePDFController extends Controller
{
    public function createForType($type, $id = null)
    {
        $field = ($type == 1)? WarehouseProduct::find($id): Warehouse::find($id);

        if (is_null($field)) {
            $inventory_product = WarehouseInventoryProduct::with(
                [
                    'currency',
                    'warehouseProduct',
                    'warehouseInventoryRule',
                    'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    },
                    'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    }
                ]
            )->orderBy('warehouse_product_id')->get();
        } elseif ($type == 1) {
            $inventory_product = WarehouseInventoryProduct::where('warehouse_product_id', $field->id)
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
                        }
                    ]
                )->orderBy('warehouse_institution_warehouse_id')->get();
        } else {
            $inventory_product = WarehouseInventoryProduct::where('warehouse_institution_warehouse_id', $field->id)
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
                        }
                    ]
                )->orderBy('warehouse_product_id')->get();
        };

        $this->createReport($inventory_product);
    }

    public function create($warehouse_id, $product_id)
    {
        $product = WarehouseProduct::find($product_id);
        $institution = Institution::where('active', true)->where('default', true)->first();
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $warehouse_id)
            ->where('institution_id', $institution->id)->first();

        if ((!is_null($product))&&(!is_null($inst_ware))) {
            $inventory_product = WarehouseInventoryProduct::where('warehouse_institution_warehouse_id', $inst_ware->id)
                ->where('warehouse_product_id', $product->id)
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
                        }
                    ]
                )->orderBy('warehouse_product_id')->orderBy('warehouse_institution_warehouse_id')->get();

            $this->createReport($inventory_product);
        }
    }

    public function createWarehouseProducts()
    {
        $inventory_product = WarehouseInventoryProduct::with(
            [
                'currency',
                'warehouseProduct',
                'warehouseInventoryRule',
                'warehouseProductValues' => function ($query) {
                    $query->with('warehouseProductAttribute');
                },
                'warehouseInstitutionWarehouse' => function ($query) {
                    $query->with('warehouse');
                }
            ]
        )->orderBy('warehouse_product_id')->orderBy('warehouse_institution_warehouse_id')->get();

        $this->createReport($inventory_product);
    }

    public function createForProduct($product_id)
    {
        $product = WarehouseProduct::find($product_id);

        if (!is_null($product)) {
            $inventory_product = WarehouseInventoryProduct::where('warehouse_product_id', $product->id)
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
                        }
                    ]
                )->orderBy('warehouse_product_id')->orderBy('warehouse_institution_warehouse_id')->get();

            $this->createReport($inventory_product);
        }
    }

    public function createForWarehouse($warehouse_id)
    {
        $institution = Institution::where('active', true)->where('default', true)->first();
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $warehouse_id)
                    ->where('institution_id', $institution->id)->first();

        if (!is_null($inst_ware)) {
            $inventory_product = WarehouseInventoryProduct::where('warehouse_institution_warehouse_id', $inst_ware->id)
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
                        }
                    ]
                )->orderBy('warehouse_product_id')->orderBy('warehouse_institution_warehouse_id')->get();

            $this->createReport($inventory_product);
        }
    }
    
    public function createReport($inventory_product)
    {
        $pdf = new Pdf('L', 'mm', 'Letter');

        /*
         *  Definicion de las caracteristicas generales de la página
         */
        $paramReportBanner = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'report_banner', 'p_value' => 'true'
        ])->first();

        if (isset($paramReportBanner) and $paramReportBanner->p_value == true) {
            $pdf->SetMargins(10, 65, 10);
        } else {
            $pdf->SetMargins(10, 55, 10);
        }

        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);

        $pdf->setTitleReport('Inventario de Productos de Almacén');
        $pdf->Open();
        $pdf->AddPage();

        $view = \View::make('warehouse::pdf.warehouse-report-product', compact('inventory_product', 'pdf'));
        $html = $view->render();
        $pdf->SetFont('Courier', 'B', 8);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output("ReporteInventario_".date("d-m-Y").".pdf");
    }
}
