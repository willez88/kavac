<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Warehouse\Models\WarehouseRequest;
use Modules\Warehouse\Models\WarehouseRequestProduct;
use Modules\Warehouse\Models\WarehouseInventaryProduct;
use Modules\Warehouse\Models\WarehouseInventaryRule;
use Modules\Warehouse\Models\Warehouse;


/**
 * @class WarehouseRequestController
 * @brief Controlador de Solicitudes de Almacén
 * 
 * Clase que gestiona las Solicitudes de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseRequestController extends Controller
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
        $this->middleware('permission:warehouse.request.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.request.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.request.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.request.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las Solicitudes de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $warehouse_requests = WarehouseRequest::with('department')->get();
        return view('warehouse::requests.list', compact('warehouse_requests'));
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud de almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        $header = [
            'route' => 'warehouse.request.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        return view('warehouse::requests.create', compact('header'));
    }

    /**
     * Valida y Registra una nueva solicitud de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'products.*' => 'required',
            'specific_action_id' => 'required',
            'department_id' => 'required',
            'motive' => 'required'

        ]);
        DB::transaction(function() use ($request) {
            $data_request = WarehouseRequest::create([
                'state' => 'Pendiente',
                'motive' => $request->input('motive'),
                'specific_action_id' => $request->input('specific_action_id'),
                'dependence_id' => $request->input('department_id')
            ]);

            foreach ($request->products as $product) {

                $inventary_product = WarehouseInventaryProduct::find($product['id']);
                if(!is_null($inventary_product)){
                    $exist_real = $inventary_product->exist - $inventary_product->reserved;
                    if($exist_real > $product['requested']){
                        WarehouseRequestProduct::create([
                            'warehouse_inventary_product_id' => $inventary_product->id,
                            'warehouse_request_id' => $data_request->id,
                            'quantity' => $product['requested'],
                        ]);
                        $inventary_product->reserved += $product['requested'];
                        $inventary_product->save();
                    }
                }
            }
        });
        return response()->json(['result' => true],200);
    }

    /**
     * Muestra el formulario para editar una solicitud de  almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {

        $warehouse_request = WarehouseRequest::find($id);
        return view('warehouse::requests.create', compact('warehouse_request'));
    }

    /**
     * Actualiza la información de las Solicitudes de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        $this->validate($request, [
            'products.*' => 'required',
            'specific_action_id' => 'required',
            'department_id' => 'required',
            'motive' => 'required'

        ]);
            
        DB::transaction(function() use ($request, $warehouse_request) {
            
            $warehouse_request->motive = $request->input('motive');
            $warehouse_request->specific_action_id = $request->input('specific_action_id');
            $warehouse_request->dependence_id = $request->input('department_id');
            $warehouse_request->save();

            foreach ($request->products as $product) {

                $inventary_product = WarehouseInventaryProduct::find($product['id']);
                if(!is_null($inventary_product)){
                    $exist_real = $inventary_product->exist - $inventary_product->reserved;
                    $old_request = WarehouseRequestProduct::where('warehouse_request_id', $warehouse_request->id)
                            ->where('warehouse_inventary_product_id', $inventary_product->id)->first();
                    if(!is_null($old_request)){
                        if($old_request->quantity > $product['requested']){

                            $inventary_product->reserved -= $old_request->quantity - $product['requested'];
                            $old_request->quantity -= $old_request->quantity - $product['requested'];
                        }
                        else if($old_request->quantity < $product['requested']){

                            $inventary_product->reserved += $product['requested'] - $old_request->quantity;
                            $old_request->quantity += $product['requested'] - $old_request->quantity;
                        }
                        $inventary_product->save();
                        $old_request->save();
                    }
                    else if($exist_real > $product['requested']){
                        $inventary_product->reserved += $product['requested'];
                        $inventary_product->save();
                        WarehouseRequestProduct::create([
                            'warehouse_inventary_product_id' => $inventary_product->id,
                            'warehouse_request_id' => $warehouse_request->id,
                            'quantity' => $product['requested'],
                        ]);
                    }
                }
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Confirma la entrega de una solicitud de almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function approved_request(Request $request, $id){
        $warehouse_request = WarehouseRequest::find($id);        
        if(!is_null($warehouse_request)){
            $warehouse_request->observation = !empty($request->observation)?$request->observation:'N/A';
            $warehouse_request->delivered = true;
            $warehouse_request->state = 'Entregado';
            $warehouse_request->delivery_date = now();
            $warehouse_request->save();
            return response()->json(['result' => true],200);
        }
    }

    /**
     * Elimina una Solicitud de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        $warehouse_request->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    /**
     * Obtiene la información de los productos inventariados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function getInventaryProduct(){

        $warehouse_product = WarehouseInventaryProduct::with(['product'=>
            function($query){
                $query->with(['attributes'=>
                    function($query){
                        $query->with('value');
                    }]);
            },'warehouseInstitution'=> function($query){
                $query->with('warehouse');

            },'rule'])->get();

        return response()->json(['records' => $warehouse_product], 200);
    }

    /**
     * Vizualiza Información de una solicitud de almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id){
        
        return response()->json(['records' => WarehouseRequest::where('id',$id)->with(['specificAction','department','requestProduct'=>
                function($query){
                    $query->with(['InventaryProduct' => 
                        function($query){
                            $query->with('product','unit');
                        }]);
                }])->first()], 200);
    }
}
