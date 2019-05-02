<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;
use Modules\Warehouse\Models\WarehouseProductValue;
use Modules\Warehouse\Models\WarehouseInventaryProductMovement;
use Modules\Warehouse\Models\WarehouseMovement;
use Modules\Warehouse\Models\Warehouse;

use Illuminate\Support\Facades\Auth;

/**
 * @class WarehouseMovementController
 * @brief Controlador de Movimientos de productos de Almacén
 * 
 * Clase que gestiona los movimientos de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseMovementController extends Controller
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
     * Muestra un listado de los Movimientos de Almacén Registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $movements = WarehouseMovement::with('start','finish')->get();
        return view('warehouse::movements.list', compact('movements'));
    }

    /**
     * Muestra el formulario para registrar un nuevo Movimiento de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('warehouse::movements.create');
    }

    /**
     * Valida y Registra un nuevo Movimiento de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'description' => 'required',
            'warehouse_start_id' => 'required',
            'warehouse_finish_id' => 'required',
            'institution_start_id' => 'required',
            'institution_finish_id' => 'required',
            'products' => 'required',
        ]);

        $inst_ware_start = WarehouseInstitutionWarehouse::where('warehouse_id',$request->warehouse_start_id)
            ->where('institution_id',$request->institution_start_id)->first();

        $inst_ware_finish = WarehouseInstitutionWarehouse::where('warehouse_id',$request->warehouse_finish_id)
            ->where('institution_id',$request->institution_finish_id)->first();

        DB::transaction(function() use ($request, $inst_ware_start, $inst_ware_finish){
            $movement = WarehouseMovement::create([
                    'type' => 1,
                    'description' => $request->description,
                    'complete' => false,
                    'warehouse_inst_start_id' => ($inst_ware_start)?$inst_ware_start->id:null,
                    'warehouse_inst_finish_id' => ($inst_ware_finish)?$inst_ware_finish->id:null,
                    'user_id' => Auth::id(),
            ]);

            foreach ($request->products as $product) {
                
                $inventary_product_init = WarehouseInventaryProduct::find($product['id']);
                if(!is_null($inventary_product_init)){
                    
                    $exist_real = $inventary_product_init->exist - $inventary_product_init->reserved;
                    if($exist_real > $product['movemented']){
                        $inventary_product_init->reserved += $product['movemented'];
                        $inventary_product_init->save();

                        # Verifico si el almacén destino tiene un registro previo del producto movilizado
                        $products_inventary = WarehouseInventaryProduct::where('warehouse_institution_id', $inst_ware_finish->id)
                            ->where('product_id', $inventary_product_init->product_id)
                            ->where('unit_id', $inventary_product_init->unit_id)
                            ->where('unit_value', $inventary_product_init->unit_value)->get();
                            
                        # Si existe comparo los atributos perzonalizados si los tiene
                        if( ( count($products_inventary) > 0 ) ){
                            foreach ($products_inventary as $inventary_product_finish) {
                                $equal = true;
                                
                                # Se verifica que tengan los mismos atributos
                                $attributes = WarehouseProductAttribute::where('product_id', $inventary_product_init->product_id)->with('value')->get();
                                foreach ($attributes as $attribute) {
                                    $value_init = WarehouseProductValue::where('attribute_id', $attribute)
                                                  ->where('inventary_id',$inventary_product_init->id)->first();
                                    $value_finish = WarehouseProductValue::where('attribute_id', $attribute)
                                                  ->where('inventary_id',$inventary_product_finish->id)->first();
                                    
                                    # Si alguno no existe o son diferentes rompo el ciclo paro no revisar los demas atributos perzonalizados
                                    if(is_null($value_init) || is_null($value_finish) || ($value_init != $value_finish)){
                                        $equal = false;
                                        break;
                                    }
                                } # Si todos los atributos son iguales genero el movimiento
                                if ($equal == true){
                                    $inventary_movement = WarehouseInventaryProductMovement::create([
                                        'quantity' => $product['movemented'],
                                        'new_value' => $inventary_product_init->unit_value,
                                        'movement_id' => $movement->id,
                                        'inventary_product_init_id' => $inventary_product_init->id,
                                        'inventary_product_id' => $inventary_product_finish->id,
                                    ]);
                                    # Rompo el ciclo para no revisar los demas productos
                                    break;
                                }
                            }
                        } # Si no existe registro previo generamos un nuevo registro de inventario y un movimiento
                        if( (count($products_inventary) == 0) || ( $equal == false ) ){
                            
                            # Se declara la existencia en null hasta que se confirme la operación
                            $inventary_product_finish = WarehouseInventaryProduct::create([
                                'product_id' => $inventary_product_init->product_id,
                                'unit_id' => $inventary_product_init->unit_id,
                                'unit_value' => $inventary_product_init->unit_value,
                                'warehouse_institution_id' => $inst_ware_finish->id,
                            ]);

                            # Se genera el movimiento
                            $inventary_movement = WarehouseInventaryProductMovement::create([
                                'quantity' => $product['movemented'],
                                'new_value' => $inventary_product_init->unit_value,
                                'movement_id' => $movement->id,
                                'inventary_product_init_id' => $inventary_product_init->id,
                                'inventary_product_id' => $inventary_product_finish->id,
                            ]);
                        }
                    } # Si la exitencia del producto es menor que lo que queremos desplazar a ocurrido un error
                    else{
                        DB::rollback();
                    }
                } # Si no existe un registro del producto en el almacén inicial a ocurrido un error
                else{
                    DB::rollback();
                }

            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Muestra el formulario para editar un Movimiento de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $movement = WarehouseMovement::find($id);
        return view('warehouse::movements.create',compact('movement'));
    }

    /**
     * Actualiza la información de los Movimientos de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $movement = WarehouseMovement::find($id);
        $this->validate($request,[
            'description' => 'required',
            'warehouse_start_id' => 'required',
            'warehouse_finish_id' => 'required',
            'institution_start_id' => 'required',
            'institution_finish_id' => 'required',
            'products' => 'required',
        ]);

        DB::transaction(function() use ($request, $movement){
            $movement->description = $request->description;
            $movement->save();

            foreach ($request->products as $product) {
                
                $inventary_product_init = WarehouseInventaryProduct::find($product['id']);
                if(!is_null($inventary_product_init)){
                    
                    $exist_real = $inventary_product_init->exist - $inventary_product_init->reserved;
                    $old_product_movement = WarehouseInventaryProductMovement::where('inventary_product_init_id',$inventary_product_init->id)->where('movement_id',$movement->id)->first();

                    if(!is_null($old_product_movement)){

                        if($old_product_movement->quantity > $product['movemented']){

                            $inventary_product_init->reserved -= $old_product_movement->quantity - $product['movemented'];
                            $old_product_movement->quantity -= $old_product_movement->quantity - $product['movemented'];
                        }
                        else if($old_product_movement->quantity < $product['movemented']){

                            $inventary_product_init->reserved += $product['movemented'] - $old_product_movement->quantity;
                            $old_product_movement->quantity += $product['movemented'] - $old_product_movement->quantity;
                        }
                        $inventary_product_init->save();
                        $old_product_movement->save();
                    } # Si no existe se genera un registro nuevo

                    else if($exist_real > $product['movemented']){
                        $inventary_product_init->reserved += $product['movemented'];
                        $inventary_product_init->save();

                        # Verifico si el almacén destino tiene un registro previo del producto movilizado
                        $products_inventary = WarehouseInventaryProduct::where('warehouse_institution_id', $inst_ware_finish->id)
                            ->where('product_id', $inventary_product_init->product_id)
                            ->where('unit_id', $inventary_product_init->unit_id)
                            ->where('unit_value', $inventary_product_init->unit_value)->get();
                            
                        # Si existe comparo los atributos perzonalizados si los tiene
                        if(!empty($products_inventary)){
                            foreach ($products_inventary as $inventary_product_finish) {
                                $equal = true;
                                
                                # Se verifica que tengan los mismos atributos
                                $attributes = WarehouseProductAttribute::where('product_id', $inventary_product_init->product_id)->with('value')->get();
                                foreach ($attributes as $attribute) {
                                    $value_init = WarehouseProductValue::where('attribute_id', $attribute)
                                                  ->where('inventary_id',$inventary_product_init->id)->first();
                                    $value_finish = WarehouseProductValue::where('attribute_id', $attribute)
                                                  ->where('inventary_id',$inventary_product_finish->id)->first();
                                    
                                    # Si alguno no existe o son diferentes rompo el ciclo paro no revisar los demas atributos perzonalizados
                                    if(!(!is_null($value_init) && !is_null($value_finish) && ($value_init == $value_finish))){
                                        $equal = false;
                                        break;
                                    }
                                } # Si todos los atributos son iguales genero el movimiento
                                if ($equal == true){
                                    $inventary_movement = WarehouseInventaryProductMovement::create([
                                        'quantity' => $product['movemented'],
                                        'new_value' => $inventary_product_init->unit_value,
                                        'movement_id' => $movement->id,
                                        'inventary_product_init_id' => $inventary_product_init->id,
                                        'inventary_product_id' => $inventary_product_finish->id,
                                    ]);
                                    # Rompo el ciclo para no revisar los demas productos
                                    break;
                                }
                            }
                        } # Si no existe registro previo generamos un nuevo registro de inventario y un movimiento
                        if(empty($products_inventary) || $equal == false){
                            
                            # Se declara la existencia en null hasta que se confirme la operación
                            $inventary_product_finish = WarehouseInventaryProduct::create([
                                'product_id' => $inventary_product_init->product_id,
                                'unit_id' => $inventary_product_init->unit_id,
                                'unit_value' => $inventary_product_init->unit_value,
                                'warehouse_institution_id' => $inst_ware_finish->id,
                            ]);

                            # Se genera el movimiento
                            $inventary_movement = WarehouseInventaryProductMovement::create([
                                'quantity' => $product['movemented'],
                                'new_value' => $inventary_product_init->unit_value,
                                'movement_id' => $movement->id,
                                'inventary_product_init_id' => $inventary_product_init->id,
                                'inventary_product_id' => $inventary_product_finish->id,
                            ]);
                        }
                    } # Si la exitencia del producto es menor que lo que queremos desplazar a ocurrido un error
                    else
                        DB::rollback();
                } # Si no existe un registro del producto en el almacén inicial a ocurrido un error
                else
                    DB::rollback();

            }
        });
        return response()->json(['result' => true], 200);

    }
    
    /**
     * Confirma la solicitud de un movimientro entre almacenes
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del movimiento de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function approved_movement(Request $request, $id){
        $movement = WarehouseMovement::find($id);        
        if(!is_null($movement)){
            $movement->observation = !empty($request->observation)?$request->observation:'N/A';
            $movement->complete = true;
            $movement->save();
            return response()->json(['result' => true],200);
        }
    }

    /**
     * Elimina un Movimiento de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $warehouse_movement = WarehouseMovement::find($id);
        $warehouse_movement->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    public function vueList($warehouse,$institution){
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
                return response()->json(['records' => $warehouse_product], 200);
        }

        return response()->json(['records' => [] ], 200);
    }

    /**
     * Vizualiza la Información de un movimientro entre almacenes
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
