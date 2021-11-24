<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleQuote;
use Modules\Sale\Models\SaleQuoteProduct;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Modules\Sale\Models\SaleTypeGood;
use App\Models\HistoryTax;
use Modules\Sale\Models\SaleClient;
use Modules\Sale\Models\SaleClientsEmail;
use App\Models\Phone;
use App\Rules\Rif as RifRule;

/**
 * @class SaleQuoteControlle
 * @brief Controlador de cotizaciones en el modulo de comercializacion
 *
 * Controlador de cotizaciones en el modulo de comercializacion
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleQuoteController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];
    // -1 Rejected, 0 Created and 1 approved
    /** @var initial_status estado inicial */
    protected $initial_status = 0;
    protected $approved_status = 1;
    protected $rejected_status = 2;
    protected $status_list = [2 => 'Cancelado', 0 => 'Creado', 1 => 'Aprobado'];

    /**
     * Define la configuración de la clase
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador 
        $this->middleware('permission:sale.quote.list', ['only' => 'index']);
        $this->middleware('permission:sale.quote.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.quote.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.quote.delete', ['only' => 'destroy']);
        */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('sale::quotes.list');
    }

    /**
     * Muestra el formulario para registrar una nueva Cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('sale::quotes.create');
    }

    /**
     * Valida y registra un nuevo producto
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->saleQuoteValidate($request);
        foreach ($this->getSaleSaleQuoteFields() as $id) {
          if ($id != 'status') {
            $inputs[$id] = $request->input($id);
          }
          else {
            $inputs[$id] = $this->initial_status;
          }
        }
        $inputs['total_without_tax'] = 0;
        $inputs['total'] = 0;
        $SaleQuote = SaleQuote::create($inputs);
        $products = count($request->sale_quote_products) > 0? $request->sale_quote_products : [];
        $totals = $this->createProducts($products, $SaleQuote->id);
        
        $SaleQuote->total = $totals['total'];
        $SaleQuote->total_without_tax = $totals['total_without_tax'];
        $SaleQuote->save();
        $request->session()->flash('message', ['type' => 'Save']);
        return response()->json(['result' => true, 'redirect' => route('sale.quotes.index')], 200);
    }

    /**
     * Muestra el formulario para editar una cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit(SaleQuote $SaleQuote)
    {
        $width = [
          'salePaymentMethod',
          'saleQuoteProduct.saleWarehouseInventoryProduct',
          'saleQuoteProduct.saleTypeGood',
          'saleQuoteProduct.SaleListSubservices',
          'saleQuoteProduct.measurementUnit',
          'saleQuoteProduct.Currency',
          'saleQuoteProduct.historyTax',
        ];
        $quote = SaleQuote::with($width)->find($SaleQuote->id);
        return view('sale::quotes.create', ['quoteid' => $SaleQuote->id, 'quote' => $quote]);
    }

    /**
     * Actualiza una cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, SaleQuote $SaleQuote)
    {

        $this->saleQuoteValidate($request);
        foreach ($this->getSaleSaleQuoteFields() as $id) {
          if ($id != 'status') {
            $SaleQuote->{$id} = $request->input($id);
          }
          else {
            $SaleQuote->{$id} = $this->initial_status;
          }
        }
        $products = count($request->sale_quote_products) > 0? $request->sale_quote_products : [];
        $totals = $this->createProducts($products, $SaleQuote->id);
        
        $SaleQuote->total = $totals['total'];
        $SaleQuote->total_without_tax = $totals['total_without_tax'];
        $SaleQuote->save();
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.quotes.index')], 200);
    }

    /**
     * Elimina una cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(SaleQuote $SaleQuote)
    {
      $this->createProducts([], $SaleQuote->id);
      $SaleQuote->delete();
      return response()->json(['result' => true, 'redirect' => route('sale.quotes.index')], 200);
    }

    /**
     * Realiza la validación de una cotizacion
     *
     * @method    saleSettingProductValidate
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     object    Request    $request         Objeto con datos de la peticióncurrency_id
     */
    public function saleQuoteValidate(Request $request)
    {
        $validation = [];
        $validation['type_person'] = ['required'];
        $validation['name'] = ['required', 'max:100'];
        $validation['id_number'] = ['required', 'max:60'];
        $validation['phone'] = ['required', 'regex:/^\d{3}-\d{7}$/u'];
        $validation['email'] = ['required', 'email'];
        $validation['sale_payment_method_id'] = ['required'];
        $validation['sale_quote_products'] = ['required'];
        $todayDate = date('Y-m-d');
        $validation['deadline_date'] = ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . $todayDate];
        $validation['sale_quote_products.*.product_type'] = ['required'];
        $validation['sale_quote_products.*.sale_type_good_id'] = ['required_if:sale_quote_products.*.type_product,"Servicios"'];
        $validation['sale_quote_products.*.sale_warehouse_inventory_product'] = ['required_if:sale_quote_products.*.type_product,"Productos"'];
        $validation['sale_quote_products.*.value'] = ['required', 'numeric', 'gt:0'];
        $validation['sale_quote_products.*.currency_id'] = ['required'];
        $validation['sale_quote_products.*.measurement_unit_id'] = ['required'];
        $validation['sale_quote_products.*.quantity'] = ['required', 'integer', 'gt:0'];
        $this->validate($request, $validation);
    }

    /**
     * Agrega los productos a una cotizacion
     *
     * @method    createProducts
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     array    $products         Arreglo con los atributos a agregar
     * @param     integer   $id        Identificador de la Cotizacion
     */
    public function createProducts($products = [], $id = 0)
    {
        $total = 0;
        $total_without_tax = 0;
        if ($id) {
            SaleQuoteProduct::where('sale_quote_id', $id)->delete();
            foreach ($products as $product) {
                $new_product = [];
                foreach ($this->getSaleSaleQuoteProductsFields() as $id_field) {
                  if (isset($product[$id_field])) {
                    $new_product[$id_field] = $product[$id_field];
                  }
                }
                $tax_value = ($tax = HistoryTax::find($product['history_tax_id']))? $tax->percentage / 100 : 0; 
                $new_product['sale_quote_id'] = $id;
                $new_product['total_without_tax'] = $new_product['value'] * $new_product['quantity'];
                $total_without_tax += $new_product['total_without_tax'];
                $new_product['total'] = $new_product['total_without_tax'] + $new_product['total_without_tax'] * $tax_value;
                $total += $new_product['total'];
                $product = SaleQuoteProduct::create($new_product);
            }
        }
        return ['total_without_tax' => $total_without_tax, 'total' => $total];
    }

    /**
     * Obtiene los campos de una cotizacion
     *
     * @method    getSaleSaleQuoteFields
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function getSaleSaleQuoteFields()
    {
        return ['name','id_number', 'email', 'type_person', 'sale_payment_method_id', 'deadline_date', 'status', 'phone'];
    }

    /**
     * Obtiene los campos de un producto en una cotizacion
     *
     * @method    getSaleSaleQuoteProductsFields
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function getSaleSaleQuoteProductsFields()
    {
        return [
          'value',
          'product_type',
          'sale_quote_id',
          'currency_id',
          'measurement_unit_id',
          'quantity',
          'total',
          'total_without_tax',
          'sale_warehouse_inventory_product_id',
          'sale_type_good_id',
          'history_tax_id',
          'sale_list_subservices_id',
        ];
    }

    /**
     * Rechaza una cotizacion
     *
     * @method    rejectedQuote
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function rejectedQuote(Request $request, SaleQuote $SaleQuote)
    {
        if ($SaleQuote->status != $this->initial_status) {
            $request->session()->flash('message', [
              'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
               'text' => 'La cotización no se encuentra en un estado que se pueda cambiar su valor'
            ]);
            return response()->json(['result' => false, 'redirect' => route('sale.quotes.index')], 200);
        }
        $SaleQuote->status = $this->rejected_status;
        $SaleQuote->save();
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.quotes.index')], 200);
    }

    /**
     * Aprueba una cotizacion
     *
     * @method    approvedQuote
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function approvedQuote(Request $request, SaleQuote $SaleQuote)
    {
        if ($SaleQuote->status != $this->initial_status) {
            $request->session()->flash('message', [
              'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
               'text' => 'La cotización no se encuentra en un estado que se pueda cambiar su valor'
            ]);
            return response()->json(['result' => false, 'redirect' => route('sale.quotes.index')], 200);
        }
        $SaleQuote->status = $this->approved_status;
        $SaleQuote->save();
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.quotes.index')], 200);
    }


    /**
     * Vizualiza información de una cotizacion
     *
     * @method    vueInfo
     * @param  SaleQuote $SaleQuote Objeto con la cotizacion
     * @return \Illuminate\Http\JsonResponse (JSON con la cotizacion)
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function vueInfo(SaleQuote $SaleQuote)
    {
        $width = [
          'salePaymentMethod',
          'saleQuoteProduct.saleWarehouseInventoryProduct',
          'saleQuoteProduct.saleTypeGood',
          'saleQuoteProduct.SaleListSubservices',
          'saleQuoteProduct.measurementUnit',
          'saleQuoteProduct.Currency',
          'saleQuoteProduct.historyTax',
        ];
        $quote = SaleQuote::with($width)->find($SaleQuote->id);
        return response()->json(['record' => $quote], 200);
    }

    /**
     * Obtiene un listado de cotizaciones
     *
     * @method    vueList
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
      return response()->json(['records' => SaleQuote::with(['saleQuoteProduct', 'salePaymentMethod'])->get()], 200);
    }

    /**
     * Obtiene un listado de las cotizacion
     *
     * @method    vueStateList
     * @param  (int) $status estado de la cotizacion (ver atributo status)
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueStateList($status = '0')
    {
        $SaleQuotes = SaleQuote::where('status', $status)->get();
        return response()->json(['records' => $SaleQuotes], 200);
    }

    /**
     * Muestra una lista del porcentaje de impuestos registrados en el sistema
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los impuestos
     */
    public function getTaxes()
    {
        return template_choices('App\Models\HistoryTax', ['percentage'], '', true);
    }

    /**
     * Muestra una lista de los distintos estados que puede tener una cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return JsonResponse
     */

    public function getSaleQuoteStatus()
    {
        return response()->json(['records' => $this->status_list], 200);
    }

    /**
     * Muestra una lista de los productos en el almacen
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los productos
     */
    public function getInventoryProducts()
    {
        return template_choices('Modules\Sale\Models\SaleWarehouseInventoryProduct', ['code'], '', true);
    }

    /**
     * Muestra una lista de los subservicios
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los subservicios
     */
    public function getSaleListSubservices()
    {
        return template_choices('Modules\Sale\Models\SaleListSubservices', ['name'], '', true);
    }

    /**
     * Muestra una lista los metodos de pago
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los subservicios
     */
    public function getSalePayments()
    {
        return template_choices('Modules\Sale\Models\SalePaymentMethod', ['name'], '', true);
    }

    /**
     * Obtiene el resgistro del producto en el almacen
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     Integer    $type_id    Identificador único del producto en el almacen
     * @return    Array      Arreglo con los registros a mostrar
     */
    public function getPriceProduct($id = null)
    {
        $product = SaleWarehouseInventoryProduct::find($id);
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el registro del bien a comercializar
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param     Integer    $type_id    Identificador único del tipo de bien
     * @return    Array      Arreglo con los registros a mostrar
     */
    public function getPriceService($id = null)
    {
        $product = SaleTypeGood::find($id);
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    /**
     * Muestra una lista de los productos para ser comercializados
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los registros a mostrar
     */
    public function getQuoteGoodsToBeTradeds()
    {
        return template_choices('Modules\Sale\Models\SaleTypeGood', ['name'], '', true);
    }

    /**
     * Muestra una lista de las unidades de medida
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Array con los registros a mostrar
     */
    public function getMeasurementUnits()
    {
        return template_choices('App\Models\MeasurementUnit', ['acronym', '-', 'name'], '', true);
    }


    /**
     * Obtiene una lista con los clientes registrados
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleClients()
    {
        $saleClients = SaleClient::with(['phones', 'saleClientsEmail'])->get();
        $clients = [];
        foreach($saleClients as $client) {
          $clients[] = $client;
        }
        return response()->json($clients, 200);
    }
}
