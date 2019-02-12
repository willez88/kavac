<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;


/**
 * @class WarehouseProductAttributeController
 * @brief Controlador de los atributos de los productos de almacén
 * 
 * Clase que gestiona los atributos de productos almacenables
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseProductAttributeController extends Controller
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
        $this->middleware('permission:warehouse.setting.attribute');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => []], 200);
    }

    public function product($id)
    {
        return response()->json(['records' => WarehouseProductAttribute::where('product_id', '=',$id)->get()], 200);
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
            'product_id' => 'required',
        ]);
        
        $id = $request->input('product_id');

        $attribute = WarehouseProductAttribute::create([
            'name' => $request->input('name'),
            'product_id' => $request->input('product_id'),
        ]);
        
        return response()->json(['records' => WarehouseProductAttribute::where('product_id', '=',$id)->get()], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, WarehouseProductAttribute $attribute)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'product_id' => 'required',
        ]);
 
        $attribute->name = $request->input('name');
        $attribute->product_id = $request->input('product_id');
        $attribute->save();

        $id = $attribute->product_id;
 
        return response()->json(['records' => WarehouseProductAttribute::where('product_id', '=',$id)->get()], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseProductAttribute $attribute)
    {
        $attribute->delete();
        return response()->json(['record' => $attribute, 'message' => 'Success'], 200);
    }
}
