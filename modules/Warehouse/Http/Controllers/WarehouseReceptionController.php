<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $receptions = WarehouseMovement::with('finish')->get();
        return view('warehouse::receptions.list', compact('receptions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('warehouse::receptions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
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
                'product.'.$i.'.min' => 'required',
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

        // Una vez validados todos los datos creamos el registro
        
        for($i=0; $i< $tam; $i++){
            $attributes = $request->product[$i]['attributes'];
            $att = count($attributes);

            $product = $request->product[$i]['product_id'];
            $unit = $request->product[$i]['unit_id'];
            $quantity = $request->product[$i]['quantity'];
            $value = $request->product[$i]['unit_value'];


            // Se busca en el inventario por producto y unidad si existe un registro previo

            $inventary = WarehouseInventaryProduct::where('product_id', $product)->where('unit_id',$unit)->get();

            // Si existe un registro previo se verifica el precio y los atributos del nuevo ingreso
            if (count($inventary) > 0 ){
                
                // Si existe un producto en el mismo almacen, con la misma unidad al mismo precio

                $inventary = $inventary->where('unit_value', $value)->where('warehouse_id', $request->warehouse_id)->first();

                // Depaso con los mismos detalles
                $equal = true;
                for ($j=0; $j < $att; $j++) { 
                    $name  = $attributes[$j]['name'];
                    $value = $attributes[$j]['value'];

                    $product_att = WarehouseProductAttribute::where('product_id',$product)->where('name', $name)->first();

                    if (!is_null($product_att)){
                        
                        $product_value = WarehouseProductValues::where('value', $value)->where('attribute_id',$product_att->id)->where('inventary_id', $inventary->id)->first();

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

                }if ($equal === true){
                    //Si todos los atributos de este producto son iguales ajustamos la existencia (exist_actual + exist_add)
                    $inventary->exist = $inventary->exist + $quantity;
                    $inventary->save();

                    $movement = WarehouseMovement::create([
                        'type' => 0,
                        'observation' => 'Registro manual de productos en el inventario del almacén',
                        'complete' => true,
                        'warehouse_inst_finish_id' => $inst_ware->id,
                        'user_id' => Auth::id(),
                    ]);
                    /*
                     * Deberia generar un registro en movimiento de almacen?????
                     */
                }
            }
            //Si no existe un registro previo de ese producto en inventario o algún atributo es diferente (se genera un nuevo registro)
            else if ( ( count($inventary) === 0) || ($equal === false)  ) {
                $product_inventary = WarehouseInventaryProduct::create([
                    'product_id' => $product,
                    'exist' => $quantity,
                    'unit_id' => $unit,
                    'unit_value' => $value,
                    'warehouse_id' => $request->warehouse_id,

                ]);                
                //revisar
                //'warehouse_inst_finish_id' => $inst_ware->id,
                $movement = WarehouseMovement::create([
                    'type' => 0,
                    'observation' => 'Registro manual de productos en el inventario del almacén',
                    'complete' => true,
                    'warehouse_inst_finish_id' => 1,//$inst_ware->id,
                    'user_id' => Auth::id(),
                ]);

                for ($j=0; $j < $att; $j++) { 
                    $name = $request->product[$i]['attributes'][$j]['name'];
                    $value = $request->product[$i]['attributes'][$j]['value'];

                    $field = WarehouseProductAttribute::where('product_id',$product)->where('name', $name)->first();

                    WarehouseProductValues::updateorcreate([
                        'value' => $value,
                        'attribute_id' => $field->id,
                        'inventary_id' => $product_inventary->id,
                    ]);

                }

            }
            
        }

        return response()->json(['records' => $inventary], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('warehouse::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('warehouse::edit');
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
