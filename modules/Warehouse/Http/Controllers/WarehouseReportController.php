<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Models\Institution;
use Modules\Warehouse\Models\Warehouse;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;

class WarehouseReportController extends Controller
{
    public function create()
    {
        return view('warehouse::reports.warehouse_report_products');
    }

    public function vueListProduct($type, $id = null)
    {
        $field = ($type == 1)? WarehouseProduct::find($id):Warehouse::find($id);
        
    	if(is_null($field)){
    		$warehouse_product = WarehouseInventaryProduct::with(['product'=>
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
			$warehouse_product = WarehouseInventaryProduct::where('product_id',$field->id)
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
            $warehouse_product = WarehouseInventaryProduct::where('warehouse_institution_id',$field->id)
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
    	return response()->json(['records' => $warehouse_product], 200);
    }

    public function vueList($product_id, $warehouse_id)
    {
        $product = WarehouseProduct::find($product_id);
        $institution = Institution::where('active',true)->where('default',true)->first();
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id',$warehouse_id)
                    ->where('institution_id',$institution->id)->first();

        if((!is_null($product))&&(!is_null($inst_ware))){
            $warehouse_product = WarehouseInventaryProduct::where('warehouse_institution_id',$inst_ware->id)
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
        }

        return response()->json(['records' => ($warehouse_product)?$warehouse_product:null], 200);
    }

}
