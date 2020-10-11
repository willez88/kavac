<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleSettingProduct;
use Modules\Sale\Models\SaleSettingProductType;

class SaleSettingProductController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */

    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador *//*
        $this->middleware('permission:sale.setting.product.list', ['only' => 'index']);
        $this->middleware('permission:sale.setting.produtc.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.setting.product.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.setting.product.delete', ['only' => 'destroy']);*/
    }

    /**
     * Muestra todos los registros de los productos
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => SaleSettingProduct::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //return view('sale::create');
    }

    /**
     * Valida y registra un nuevo producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sale_setting_product_type_id' => ['required'],
        ]);

        $saleSettingProductType1 = SaleSettingProductType::where('name', 'Producto')->first()->id;
        $saleSettingProductType2 = SaleSettingProductType::where('name', 'Servicio')->first()->id;

        if ($request->sale_setting_product_type_id == $saleSettingProductType1
        ) {
            $this->validate($request, [
                'name' => ['required', 'max:100'],
                'code' => ['required', 'max:100'],
                'description' => ['required', 'max:200'],
                'price' => ['required', 'max:100'],
                'iva' => ['required', 'max:100'],
            ]);

            $saleSettingProduct = SaleSettingProduct::create([
                'sale_setting_product_type_id' => $request->sale_setting_product_type_id, 'name' => $request->name,
                'code' => $request->code, 'description' => $request->description, 'price' => $request->price,
                'iva' => $request->iva
            ]);
            return response()->json(['record' => $saleSettingProduct, 'message' => 'Success'], 200);
        }

        if ($request->sale_setting_product_type_id == $saleSettingProductType2
        ) {
            $this->validate($request, [
                'name' => ['required', 'max:100'],
                'code' => ['required', 'max:100'],
                'description' => ['required', 'max:200'],
                'price' => ['required', 'max:100'],
                'iva' => ['nullable'],
            ]);

            $saleSettingProduct = SaleSettingProduct::create([
                'sale_setting_product_type_id' => $request->sale_setting_product_type_id, 'name' => $request->name,
                'code' => $request->code, 'description' => $request->description, 'price' => $request->price,
                'iva' => $request->iva
            ]);
            return response()->json(['record' => $saleSettingProduct, 'message' => 'Success'], 200);
        }
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        //return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        //return view('sale::edit');
    }

    /**
     * Actualiza la información del producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del datos a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $saleSettingProduct = SaleSettingProduct::find($id);
        $this->validate($request, [
            'sale_setting_product_type_id' => ['required'],
        ]);

        $saleSettingProductType1 = SaleSettingProductType::where('name', 'Producto')->first()->id;
        $saleSettingProductType2 = SaleSettingProductType::where('name', 'Servicio')->first()->id;

        if ($request->sale_setting_product_type_id == $saleSettingProductType1
        ) {
            $this->validate($request, [
                'name' => ['required', 'max:100'],
                'code' => ['required', 'max:100'],
                'description' => ['required', 'max:200'],
                'price' => ['required', 'max:100'],
                'iva' => ['required', 'max:100'],
            ]);

            $saleSettingProduct->sale_setting_product_type_id  = $request->sale_setting_product_type_id;
            $saleSettingProduct->name  = $request->name;
            $saleSettingProduct->code  = $request->code;
            $saleSettingProduct->description = $request->description;
            $saleSettingProduct->price  = $request->price;
            $saleSettingProduct->iva  = $request->iva;
            $saleSettingProduct->save();
            return response()->json(['message' => 'Success'], 200);
        }

        if ($request->sale_setting_product_type_id == $saleSettingProductType2
        ) {
            $this->validate($request, [
                'name' => ['required', 'max:100'],
                'code' => ['required', 'max:100'],
                'description' => ['required', 'max:200'],
                'price' => ['required', 'max:100'],
                'iva' => ['nullable'],
            ]);

            $saleSettingProduct->sale_setting_product_type_id  = $request->sale_setting_product_type_id;
            $saleSettingProduct->name  = $request->name;
            $saleSettingProduct->code  = $request->code;
            $saleSettingProduct->description = $request->description;
            $saleSettingProduct->price  = $request->price;
            $saleSettingProduct->iva  = $request->iva;
            $saleSettingProduct->save();
            return response()->json(['message' => 'Success'], 200);
        }
    }

    /**
     * Elimina el producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  integer $id                      Identificador del producto a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $saleSettingProduct = SaleSettingProduct::find($id);
        $saleSettingProduct->delete();
        return response()->json(['record' => $saleSettingProduct, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los productos registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleSettingProduct()
    {
        return response()->json(template_choices(SaleSettingProduct::class, '', 'name', '', '', '', '', true));
    }
}
