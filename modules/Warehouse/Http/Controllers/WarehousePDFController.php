<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Warehouse\Models\Warehouse;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use App\Models\Institution;
use App\Models\Setting;

use Modules\Warehouse\Pdf\Pdf;
/**
 * @class WarehousePDFController
 * @brief Controlador de los atributos de los productos de almacén
 * 
 * Clase que gestiona los atributos de productos almacenables
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehousePDFController extends Controller
{
    public function createForType($type, $id = null)
    {

        $field = ($type == 1)? WarehouseProduct::find($id): Warehouse::find($id);

        if(is_null($field)){
            $inventary_product = WarehouseInventaryProduct::with(['product'=>
                function($query){
                    $query->with(['attributes'=>
                        function($query){
                            $query->with('value');
                        }]);
                },'warehouseInstitution' =>
                        function($query){
                            $query->with('warehouse');
                        },'rule'])->orderBy('product_id')->get();

        }
        else if($type == 1){
            $inventary_product = WarehouseInventaryProduct::where('product_id',$field->id)
                ->with(['product'=>
                function($query){
                    $query->with(['attributes'=>
                        function($query){
                            $query->with('value');
                        }]);
                },'warehouseInstitution' =>
                        function($query){
                            $query->with('warehouse');
                        },'rule'])->orderBy('warehouse_institution_id')->get();

        }
        else{
            $inventary_product = WarehouseInventaryProduct::where('warehouse_institution_id',$field->id)
                ->with(['product'=>
                function($query){
                    $query->with(['attributes'=>
                        function($query){
                            $query->with('value');
                        }]);
                },'warehouseInstitution' =>
                        function($query){
                            $query->with('warehouse');
                        } ,'rule'])->orderBy('product_id')->get();

        }

        $this->createReport($inventary_product);
    }

    public function createProduct($product_id, $warehouse_id)
    {
        $product = WarehouseProduct::find($product_id);
        $institution = Institution::where('active',true)->where('default',true)->first();
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id',$warehouse_id)
                    ->where('institution_id',$institution->id)->first();

        if((!is_null($product))&&(!is_null($inst_ware))){
            $inventary_product = WarehouseInventaryProduct::where('warehouse_institution_id',$inst_ware->id)
                ->where('product_id',$product->id)
                ->with(['product'=>
                function($query){
                    $query->with(['attributes'=>
                        function($query){
                            $query->with('value');
                        }]);
                },'warehouseInstitution' =>
                        function($query){
                            $query->with('warehouse');
                        },'rule'])->orderBy('product_id')->orderBy('warehouse_institution_id')->get();
            $this->createReport($inventary_product);
        }
    }
    
    public function createReport($inventary_product){
        $setting = Setting::all()->first();        
        $pdf = new Pdf('L','mm','Letter');

        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true)
            $pdf->SetMargins(10, 65, 10);
        else
            $pdf->SetMargins(10, 55, 10);

        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_FOOTER);

        $pdf->setTitleReport('Inventario de Productos de Almacén');
        $pdf->Open();
        $pdf->AddPage();

        $view = \View::make('warehouse::pdf.warehouse-report-product',compact('inventary_product','pdf'));
        $html = $view->render();
        $pdf->SetFont('Courier','B',8);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output("ReporteInventario_".date("d-m-Y").".pdf");
    }
}
