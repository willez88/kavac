<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;
use Modules\Warehouse\Models\WarehouseProductValue;


/**
 * @class WarehouseProductController
 * @brief Controlador de los productos de almacén
 * 
 * Clase que gestiona los Productos almacenables
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseProductController extends Controller
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
        $this->middleware('permission:warehouse.setting.product');
    }

    /**
     * Muestra un listado de los productos almacenables registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => WarehouseProduct::with('attributes')->get()], 200);
    }

    /**
     * Valida y Registra un nuevo producto almacenable
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:100',
            
        ]);

        $product = WarehouseProduct::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'attribute' => !empty($request->attribute)?$request->input('attribute'):false,
        ]);

        if ($request->atts && !empty($request->atts)) {
            foreach ($request->atts as $att) {
                $attribute = WarehouseProductAttribute::create([
                    'name' => $att['name'],
                    'product_id' => $product->id
                ]);
            }
        };

        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de los Productos Almacenables
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\WarehouseProduct $product (Registro a ser actualizado)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, WarehouseProduct $product)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:100',
            
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->attribute =  !empty($request->attribute)?$request->input('attribute'):false;
        $product->save();

        if ($request->atts && !empty($request->atts)) {
            foreach ($request->atts as $att) {
                $attribute = WarehouseProductAttribute::create([
                    'name' => $att['name'],
                    'product_id' => $product->id
                ]);
            }
        };

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina un Producto Almacenable
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(WarehouseProduct $product)
    {
        $product->delete();
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }
    /**
     * Muestra una lista de los productos almacenables para elementos del tipo select
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Array con los registros a mostrar
     */

    public function vueList()
    {
        return template_choices('Modules\Warehouse\Models\WarehouseProduct','name','',true);
    }

}
