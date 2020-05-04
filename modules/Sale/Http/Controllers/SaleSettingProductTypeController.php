<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleSettingProductType;

class SaleSettingProductTypeController extends Controller
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
     * Muestra todos los registros de los tipos de productos
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
         return response()->json(['records' => SaleSettingProductType::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Valida y registra un nuevo tipo de producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
        ]);
        $saleSettingProductType = SaleSettingProductType::create(['name' => $request->name]);
        return response()->json(['record' => $saleSettingProductType, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('sale::edit');
    }

    /**
     * Actualiza la información del tipo producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del datos a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $saleSettingProduct = SaleSettingProductType::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
        ]);
        $saleSettingProduct->name  = $request->name;
        $saleSettingProduct->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  integer $id                      Identificador del producto a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $saleSettingProductType = SaleSettingProductType::find($id);
        $saleSettingProductType->delete();
        return response()->json(['record' => $saleSettingProductType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de productos registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los tipos de productos
     */
    public function getSaleSettingProductType()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleSettingProductType', 'name',  '', true));
    }
}
