<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleSettingProductAttribute;
use Modules\Sale\Models\SaleSettingProduct;

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
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => SaleSettingProduct::with(['SaleSettingProductAttribute'])->get()], 200);
    }

    /**
     * Valida y registra un nuevo producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->saleSettingProductValidate($request);
        foreach ($this->getSaleSaleSettingProductFields() as $id) {
          if ($id != 'attributes') {
            $inputs[$id] = $request->input($id);
          }
          else {
            $inputs[$id] = !empty($request->{$id})? $request->input($id) : false;
          }
        }
        $SaleSettingProduct = SaleSettingProduct::create($inputs);
        $attributes = $inputs['attributes']? $request->sale_setting_product_attribute : [];
        $this->createAttributes($attributes, $SaleSettingProduct->id);
        return response()->json(['record' => $SaleSettingProduct, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param  integer $id                          Identificador del datos a actualizar
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function update(Request $request, $id)
    {

        $SaleSettingProduct = SaleSettingProduct::with('SaleSettingProductAttribute')->find($id);
        $this->saleSettingProductValidate($request);
        foreach ($this->getSaleSaleSettingProductFields() as $id) {
          if ($id != 'attributes') {
            $SaleSettingProduct->{$id} = $request->input($id);
          }
          else {
            $SaleSettingProduct->{$id} = !empty($request->{$id})? $request->input($id) : false;
          }
        }
        $SaleSettingProduct->save();
        $attributes = !empty($request->attributes)? $request->sale_setting_product_attribute : [];
        $this->createAttributes($attributes, $SaleSettingProduct->id);
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  integer $id                          Identificador del datos a actualizar
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function destroy($id)
    {
        $SaleSettingProduct = SaleSettingProduct::with('SaleSettingProductAttribute')->find($id);
        $this->createAttributes([], $SaleSettingProduct->id);
        $SaleSettingProduct->delete();
        return response()->json(['record' => $SaleSettingProduct, 'message' => 'Success'], 200);
    }

    /**
     * Realiza la validación de un costo fijo
     *
     * @method    saleSettingProductValidate
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     object    Request    $request         Objeto con datos de la petición
     */
    public function saleSettingProductValidate(Request $request)
    {
        $validation = [];
        $validation['name'] = ['required', 'max:60'];
        $validation['description'] = ['required'];
        if (!empty($request->attributes)) {
            $validation['sale_setting_product_attribute.*'] = ['required', 'max:100'];
        }
        $this->validate($request, $validation);
    }

    /**
     * Agrega atributos a un producto
     *
     * @method    createAttributes
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     array    $attributes         Arreglo con los atributos a agregar
     * @param     integer   $id        Identificador del Producto
     */
    public function createAttributes($attributes = [], $id = 0)
    {
        if ($id) {
            SaleSettingProductAttribute::where('sale_setting_product_id', $id)->delete();
            foreach ($attributes as $att) {
                $attribute = SaleSettingProductAttribute::create([
                    'name' => $att['name'],
                    'sale_setting_product_id' => $id
                ]);
            }
        }
    }

    /**
     * Obtiene los campos de un producto
     *
     * @method    createAttributes
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function getSaleSaleSettingProductFields()
    {
        return ['name', 'description', 'attributes'];
    }

    /**
     * Obtiene los productos registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleSettingProduct()
    {
        return response()->json(template_choices(SaleSettingProduct::class, 'name', '', true));
    }

    /**
     * Muestra una lista de los atributos de un producto
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     integer   $sale_setting_product_id        Identificador del producto
     * @return \Illuminate\Http\JsonResponse con los atributos del producto
     */
    public function getSaleSettingProductAttributes($sale_setting_product_id)
    {
        return response()->json([
            'records' => SaleSettingProductAttribute::with('SaleSettingProduct')->where(
                'sale_setting_product_id',
                $sale_setting_product_id
            )->get()
        ]);
    }
}
