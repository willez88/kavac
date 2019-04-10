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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => WarehouseProduct::with('attributes')->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseProduct $product)
    {
        $product->delete();
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    public function vueList()
    {
        return template_choices('Modules\Warehouse\Models\WarehouseProduct','name','',true);
    }

}
