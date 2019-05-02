<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Warehouse\Models\WarehouseInventaryProductMovement;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;
use Modules\Warehouse\Models\WarehouseProductValues;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Modules\Warehouse\Models\WarehouseMovement;
use Modules\Warehouse\Models\Warehouse;

use Illuminate\Support\Facades\Auth;



/**
 * @class WarehouseReceptionController
 * @brief Controlador de Recepciones de Almacén
 * 
 * Clase que gestiona las Recepciones de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseReceptionController extends Controller
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
        $this->middleware('permission:warehouse.movement.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.movement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.movement.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.movement.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las Recepciones o Ingresos de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $receptions = WarehouseMovement::with('start','finish')->get();
        return view('warehouse::receptions.list', compact('receptions'));
    }

    /**
     * Muestra el formulario para registrar un nuevo Ingreso de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('warehouse::receptions.create');
    }

    /**
     * Valida y Registra un nuevo Ingreso de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'warehouse_id' => 'required',
            'institution_id' => 'required',

        ]);
        $tam = count($request->product);
        $i=0;
        for($i=0; $i< $tam; $i++){
            $attributes = $request->product[$i]['attributes'];
            $att = count($attributes);
            $j=0;
            $this->validate($request, [
                'product.'.$i.'.product_id' => 'required',
                'product.'.$i.'.quantity' => 'required',
                'product.'.$i.'.unit_id' => 'required',
                'product.'.$i.'.unit_value' => 'required',
                
            ]);
            /*
             * Hacer validación mas detallada (ej: diferenciar tipo de dato en atributos) 
             */
            for ($j=0; $j < $att; $j++) { 
               $this->validate($request, [
                'product.'.$i.'.attributes.'.$j.'.name' => 'required',
                'product.'.$i.'.attributes.'.$j.'.value' => 'required',                
            ]); 
            }
        }


        /*********************************************************/
    
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id',$request->warehouse_id)
            ->where('institution_id',$request->institution_id)->first();

        DB::transaction( function() use($request, $inst_ware){

            $movement = WarehouseMovement::create([
                    'type' => 0,
                    'description' => 'Registro manual de productos en el inventario del almacén',
                    'complete' => true,
                    'warehouse_inst_finish_id' => $inst_ware->id,
                    'user_id' => Auth::id(),
                ]);
                
            foreach ($request->product as $product) {
                $product_id = $product['product_id'];
                $unit = $product['unit_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                // Se busca en el inventario por producto y unidad si existe un registro previo

                $inventary = WarehouseInventaryProduct::where('product_id', $product_id)->where('unit_id',$unit)->where('warehouse_institution_id',$inst_ware->id)->where('unit_value',$value)->get();
                // Si existe un registro previo se verifican los atributos del nuevo ingreso
                if ( count($inventary) > 0 ){

                    foreach ($inventary as $product_inventary) {
                        $equal = true;
                        //Verificamos que tengan los mismos atributos

                        foreach ($product['attributes'] as $attribute) {
                            $name = $attribute['name'];
                            $val = $attribute['value'];

                            $product_att = WarehouseProductAttribute::where('product_id',$product_id)->where('name', $name)->first();

                            if (!is_null($product_att)){
                                
                                $product_value = WarehouseProductValues::where('value', $val)->where('attribute_id',$product_att->id)->where('inventary_id', $product_inventary->id)->first();

                                if(is_null($product_value)){
                                    //si el valor de este atributo no existe, son diferentes
                                    $equal =false;
                                    break;
                                }
                            }
                            else{
                                $equal = false;
                                break;
                            }
                        }
                        if ($equal === true){
                            //Si todos los atributos de este producto son iguales ajustamos la existencia (exist_actual + exist_add) y generamos el movimiento
                            $product_inventary->exist = $product_inventary->exist + $quantity;
                            $product_inventary->save();
                            $inventary_movement = WarehouseInventaryProductMovement::create([
                                'quantity' => $quantity,
                                'new_value' => $value,
                                'movement_id' => $movement->id,
                                'inventary_product_id' => $product_inventary->id,
                            ]);
                            
                        }
                    }
                }
                //Si no existe un registro previo de ese producto en inventario o algún atributo es diferente (se genera un nuevo registro)
                else if ( (count($inventary) == 0) || ($equal == false)  ) {
                    $product_inventary = WarehouseInventaryProduct::create([
                        'product_id' => $product_id,
                        'exist' => $quantity,
                        'unit_id' => $unit,
                        'unit_value' => $value,
                        'warehouse_institution_id' => $inst_ware->id,
                    ]);
            
                    $inventary_movement = WarehouseInventaryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'movement_id' => $movement->id,
                        'inventary_product_id' => $product_inventary->id,
                    ]);

                    foreach ($product['attributes'] as $attribute) {

                        $name = $attribute['name'];
                        $value = $attribute['value'];

                        $field = WarehouseProductAttribute::where('product_id',$product_id)->where('name', $name)->first();

                        WarehouseProductValues::create([
                            'value' => $value,
                            'attribute_id' => $field->id,
                            'inventary_id' => $product_inventary->id,
                        ]);
                    }
                }

            }
        });

        return response()->json(['result' => true],200);
    }

    /**
     * Muestra el formulario para editar un Ingreso de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $reception = WarehouseMovement::find($id);
        return view('warehouse::receptions.create', compact("reception"));
    }

    /**
     * Actualiza la información de los Ingresos de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $warehouse_movement = WarehouseMovement::find($id);
        $this->validate($request, [
            'warehouse_id' => 'required',
            'institution_id' => 'required',
            'product' => 'required',
        ]);

        $tam = count($request->product);
        for($i=0; $i< $tam; $i++){
            $attributes = $request->product[$i]['attributes'];
            $att = count($attributes);
            $this->validate($request, [
                'product.'.$i.'.product_id' => 'required',
                'product.'.$i.'.quantity' => 'required',
                'product.'.$i.'.unit_id' => 'required',
                'product.'.$i.'.unit_value' => 'required',
                
            ]);

            for ($j=0; $j < $att; $j++) { 
               $this->validate($request, [
                'product.'.$i.'.attributes.'.$j.'.name' => 'required',
                'product.'.$i.'.attributes.'.$j.'.value' => 'required',                
            ]); 
            }
        }

        $product_movements = WarehouseInventaryProductMovement::where('movement_id', $warehouse_movement->id)->get();

        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id',$request->warehouse_id)
            ->where('institution_id',$request->institution_id)->first();

        DB::transaction( function() use($request, $warehouse_movement, $inst_ware, $product_movements){
            $warehouse_movement->warehouse_inst_finish_id = $inst_ware->id;
            $warehouse_movement->user_id = Auth::id();
            $warehouse_movement->save();

            /*
             * Asumiendo que se gestione la solicitud sobre la misma institución y almacén
             */
            foreach ($request->product as $product) {
                $product_id = $product['product_id'];
                $unit = $product['unit_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                // Se busca en el inventario por producto y unidad si existe un registro previo

                $inventary = WarehouseInventaryProduct::where('product_id', $product_id)->where('unit_id',$unit)->where('warehouse_institution_id',$inst_ware->id)->where('unit_value',$value)->get();
                // Si existe un registro previo se verifican los atributos del nuevo ingreso

                if ( count($inventary) > 0){

                    foreach ($inventary as $product_inventary) {
                        $old_inventary = $product_movements->where('inventary_product_id', $product_inventary->id)->first();

                        # si no existe el registro se agrega un nuevo registro a la solicitud
                           $equal =  (is_null($old_inventary))?false:true;
                        if( $equal == true){
                            //Verificamos que tengan los mismos atributos

                            foreach ($product['attributes'] as $attribute) {
                                $name = $attribute['name'];
                                $val = $attribute['value'];

                                $product_att = WarehouseProductAttribute::where('product_id',$product_id)->where('name', $name)->first();

                                if (!is_null($product_att)){
                                    
                                    $product_value = WarehouseProductValues::where('value', $val)->where('attribute_id',$product_att->id)->where('inventary_id', $product_inventary->id)->first();

                                #si el valor de este atributo no existe, son diferentes
                                    if(is_null($product_value))
                                        $equal =false;
                                }
                                else
                                    $equal = false;
                            }
                            # Si todos los atributos de este producto son iguales ajustamos la existencia (**)
                            if ($equal == true){
                                
                                if($old_inventary->quantity > $quantity){
                                    $product_inventary->exist -= $old_inventary->quantity - $quantity;
                                    $old_inventary->quantity -= $old_inventary->quantity - $quantity;
                                }
                                else if($old_inventary->quantity < $quantity){
                                    $product_inventary->exist += $quantity - $old_inventary->quantity ;
                                    $old_inventary->quantity += $quantity - $old_inventary->quantity;
                                }
                                $old_inventary->new_value = $value;
                                $product_inventary->save();
                                $old_inventary->save();
                            }
                        }

                    }
                }
                //Si no existe un registro previo de ese producto en inventario o algún atributo es diferente (se genera un nuevo registro)
                if ( ( count($inventary) == 0) || ($equal == false)  ) {
                    $product_inventary = WarehouseInventaryProduct::create([
                        'product_id' => $product_id,
                        'exist' => $quantity,
                        'unit_id' => $unit,
                        'unit_value' => $value,
                        'warehouse_institution_id' => $inst_ware->id,
                    ]);
            
                    $inventary_movement = WarehouseInventaryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'movement_id' => $warehouse_movement->id,
                        'inventary_product_id' => $product_inventary->id,
                    ]);

                    foreach ($product['attributes'] as $attribute) {

                        $name = $attribute['name'];
                        $value = $attribute['value'];

                        $field = WarehouseProductAttribute::where('product_id',$product_id)->where('name', $name)->first();

                        WarehouseProductValues::create([
                            'value' => $value,
                            'attribute_id' => $field->id,
                            'inventary_id' => $product_inventary->id,
                        ]);
                    }
                }
            }

        });


        return response()->json(['result' => true],200);
    }

    /**
     * Elimina un Ingreso de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $reception = WarehouseMovement::find($id);
        $reception->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    /**
     * Vizualiza la Información de una recepción o Ingreso de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id){
        
        return response()->json(['records' => WarehouseMovement::where('id',$id)->with(['productMovements' => 

            function($query){
                $query->with(['inventary' => 
                function($query){
                    $query->with(['product' =>
                    function($query){
                        $query->with(['attributes'=>
                        function($query){
                            $query->with('value');
                        }]);
                    },'unit']);
                }]);
            },'finish','start']
        )->first()], 200);
    }
}
