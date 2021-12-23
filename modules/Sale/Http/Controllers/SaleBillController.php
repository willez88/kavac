<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;
use App\Models\User;

use Modules\Sale\Models\SaleBill;
use Modules\Sale\Models\SaleBillInventoryProduct;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Modules\Sale\Models\SaleWarehouseMovement;
use Modules\Sale\Models\SaleGoodsToBeTraded;
use Modules\Sale\Notifications\BillApproved;

/**
 * @class SaleBillController
 * @brief Controlador de facturas
 *
 * Clase que gestiona las facturas del módulo de comercialización
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class SaleBillController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */

    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        // $this->middleware('permission:sale.bill.list', ['only' => 'index']);
        // $this->middleware('permission:sale.bill.create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:sale.bill.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:sale.bill.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las facturas registradas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Renderable
     */

    public function index()
    {
        return view('sale::bills.list');
    }

    /**
     * Muestra el formulario para registrar una nueva factura
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Renderable
     */

    public function create()
    {
        return view('sale::bills.create');
    }

    /**
     * Valida y registra una nueva factura
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */

    public function store(Request $request)
    {
        $codeSetting = CodeSetting::where('table', 'sale_bills')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('sale.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        DB::transaction(function () use ($request, $code) {
            if ($request->type_person == 'Natural'){
                $this->validate($request, [
                    'type_person'            => ['required'],
                    'name'                   => ['required'],
                    'id_number'              => ['required'],
                    'phone'                  => ['required'],
                    'email'                  => ['required'],
                    'sale_form_payment_id' => ['required'],
                ]);
            } else if ($request->type_person == 'Jurídica'){
                $this->validate($request, [
                    'type_person'            => ['required'],
                    'name'                   => ['required'],
                    'rif'                    => ['required'],
                    'phone'                  => ['required'],
                    'email'                  => ['required'],
                    'sale_form_payment_id' => ['required'],
                ]);
            } else {
                $this->validate($request, [
                    'type_person'            => ['required'],
                    'name'                   => ['required'],
                    'rif'                    => ['required'],
                    'id_number'              => ['required'],
                    'phone'                  => ['required'],
                    'email'                  => ['required'],
                    'sale_form_payment_id'   => ['required'],
                ]);
            }

            $data_request = SaleBill::create([
                'code'                 => $code,
                'state'                => 'Pendiente',
                'type'                 => 'N',
                'type_person'          => $request->input('type_person'),
                'name'                 => $request->input('name'),
                'id_number'            => $request->input('id_number'),
                'rif'                  => $request->input('rif'),
                'phone'                => $request->input('phone'),
                'email'                => $request->input('email'),
                'sale_form_payment_id' => $request->input('sale_form_payment_id'),
            ]);

            foreach ($request->sale_bill_products as $product) {
                if ($product['product_type'] == 'Producto') {
                    $inventory_product = SaleWarehouseInventoryProduct::find($product['sale_warehouse_inventory_product_id']);
                    if (!is_null($inventory_product)) {
                        $exist_real = $inventory_product->exist - $inventory_product->reserved;
                        if ($exist_real >= $product['quantity']) {
                            SaleBillInventoryProduct::create([
                                'sale_warehouse_inventory_product_id' => $inventory_product->id,
                                'sale_bill_id'               => $data_request->id,
                                'quantity'                   => $product['quantity'],
                                'currency_id'                => $product['currency_id'],
                                'history_tax_id'             => $product['history_tax_id'],
                                'measurement_unit_id'        => $product['measurement_unit_id'],
                                'value'                      => $product['value'],
                                'product_type'               => $product['product_type'],
                                'quantity'                   => $product['quantity'],
                            ]);
                        } else {
                            /** Si la exitencia del producto es menor que lo que se solicita
                             *  se revierten los cambios
                             */
                            DB::rollback();
                        }
                    } else {
                        /** Si no existe el registro en inventario
                         *  se revierten los cambios
                         */
                        DB::rollback();
                    }
                } else {
                    SaleBillInventoryProduct::create([
                        'sale_bill_id'               => $data_request->id,
                        'quantity'                   => $product['quantity'],
                        'currency_id'                => $product['currency_id'],
                        'history_tax_id'             => $product['history_tax_id'],
                        'measurement_unit_id'        => $product['measurement_unit_id'],
                        'sale_goods_to_be_traded_id' => $product['sale_goods_to_be_traded_id'],
                        'sale_list_subservices_id'   => $product['sale_list_subservices_id'],
                        'value'                      => $product['value'],
                        'product_type'               => $product['product_type'],
                        'quantity'                   => $product['quantity'],
                    ]);
                }
            }
        });
        $sale_bills = SaleBill::where('code', $code)->first();
        if (is_null($sale_bills)) {
            $request->session()->flash(
                'message',
                [
                    'type' => 'other',
                    'title' => 'Alerta',
                    'icon' => 'screen-error',
                    'class' => 'growl-danger',
                    'text' => 'No se pudo completar la operación.'
                ]
            );
        } else {
            $request->session()->flash('message', ['type' => 'store']);
        }
        return response()->json(['result' => true, 'redirect' => route('sale.bills.index')], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $sale_bills = SaleBill::find($id);
        return view('sale::bills.create', compact("sale_bills"));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $sale_bills = SaleBill::find($id);
        if ($request->type_person == 'Natural'){
            $this->validate($request, [
                'type_person'            => ['required'],
                'name'                   => ['required'],
                'id_number'              => ['required'],
                'phone'                  => ['required'],
                'email'                  => ['required'],
                'sale_form_payment_id' => ['required'],
            ]);
        } else if ($request->type_person == 'Jurídica'){
            $this->validate($request, [
                'type_person'            => ['required'],
                'name'                   => ['required'],
                'rif'                    => ['required'],
                'phone'                  => ['required'],
                'email'                  => ['required'],
                'sale_form_payment_id' => ['required'],
            ]);
        } else {
            $this->validate($request, [
                'type_person'            => ['required'],
                'name'                   => ['required'],
                'rif'                    => ['required'],
                'id_number'              => ['required'],
                'phone'                  => ['required'],
                'email'                  => ['required'],
                'sale_form_payment_id'   => ['required'],
            ]);
        }

        $sale_bills->type_person = $request->input('type_person');
        $sale_bills->name = $request->input('name');
        $sale_bills->id_number = $request->input('id_number');
        $sale_bills->rif = $request->input('rif');
        $sale_bills->phone = $request->input('phone');
        $sale_bills->email = $request->input('email');
        $sale_bills->sale_form_payment_id = $request->input('sale_form_payment_id');
        $sale_bills->save();

        $update = now();

        /** Se agregan los nuevos elementos a la solicitud */
        foreach ($request->sale_bill_products as $product) {
            if ($product['product_type'] == 'Producto') {
                $inventory_product = SaleWarehouseInventoryProduct::find($product['sale_warehouse_inventory_product_id']);
                if (!is_null($inventory_product)) {
                    $exist_real = $inventory_product->exist - $inventory_product->reserved;
                    if ($exist_real >= $product['quantity']) {
                        SaleBillInventoryProduct::create([
                            'sale_warehouse_inventory_product_id' => $inventory_product->id,
                            'sale_bill_id'               => $sale_bills->id,
                            'quantity'                   => $product['quantity'],
                            'currency_id'                => $product['currency_id'],
                            'history_tax_id'             => $product['history_tax_id'],
                            'measurement_unit_id'        => $product['measurement_unit_id'],
                            'value'                      => $product['value'],
                            'product_type'               => $product['product_type'],
                            'quantity'                   => $product['quantity'],
                        ]);
                    } else {
                        /** Si la exitencia del producto es menor que lo que se solicita
                         *  se revierten los cambios
                         */
                        DB::rollback();
                    }
                } else {
                    /** Si no existe el registro en inventario
                     *  se revierten los cambios
                     */
                    DB::rollback();
                }
            } else {
                SaleBillInventoryProduct::create([
                    'sale_bill_id'               => $sale_bills->id,
                    'quantity'                   => $product['quantity'],
                    'currency_id'                => $product['currency_id'],
                    'history_tax_id'             => $product['history_tax_id'],
                    'measurement_unit_id'        => $product['measurement_unit_id'],
                    'sale_goods_to_be_traded_id' => $product['sale_goods_to_be_traded_id'],
                    'sale_list_subservices_id'   => $product['sale_list_subservices_id'],
                    'value'                      => $product['value'],
                    'product_type'               => $product['product_type'],
                    'quantity'                   => $product['quantity'],
                ]);
            }
        }

        /** Se eliminan los demas elementos de la solicitud */
        $sale_bill_products = SaleBillInventoryProduct::where(
            'sale_bill_id',
            $sale_bills->id
        )->where('updated_at', '!=', $update)->get();

        foreach ($sale_bill_products as $sale_bill_product) {
            $sale_bill_product->delete();
        };

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.bills.index')], 200);
    }

    /**
     * Confirma la aprovación de una factura
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la factura
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */

    public function approvedBill(Request $request, $id)
    {
        $sale_bills = SaleBill::find($id);
        $sale_bills->state = 'Aprobado';
        $sale_bills->save();

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('slug', ['account', 'admin']);
        })->get();

        foreach ($users as $user) {
            $user->notify(new BillApproved(Auth::user(), $user, $sale_bills->code));
        };

        $bill_inventory_products = $sale_bills->SaleBillInventoryProduct;

        foreach ($bill_inventory_products as $bill_inventory_product) {
            if($bill_inventory_product->SaleWarehouseInventoryProduct){
                $sale_warehouse_inventory_product = $bill_inventory_product->SaleWarehouseInventoryProduct;
                $exist = $sale_warehouse_inventory_product->exist;
                $exist -= $bill_inventory_product->quantity;
                $sale_warehouse_inventory_product->exist = $exist;
                $sale_warehouse_inventory_product->save();
            }
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.bills.index')], 200);
    }

    /**
     * Rechaza la aprovación de una factura
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la factura
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function rejectedBill(Request $request, $id)
    {
        $this->validate($request, [
            'rejected_reason'        => ['required'],
        ]);

        $sale_bills = SaleBill::find($id);
        $sale_bills->state = 'Rechazado';
        $sale_bills->rejected_reason = $request->input('rejected_reason');
        $sale_bills->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.bills.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $sale_bills = SaleBill::find($id);
        $sale_bills->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza información de una solicitud de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function vueInfo($id)
    {
        $saleBill = SaleBill::where('id', $id)->with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }])->first();

        return response()->json(['record' => $saleBill], 200);
    }

    /**
     * Obtiene un listado de las facturas registradas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $bills = SaleBill::where('state', 'Pendiente')->with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }])->get();
        return response()->json(['records' => $bills], 200);
    }

    /**
     * Obtiene un listado de las facturas aprobadas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueApprovedList()
    {
        $bills = SaleBill::where('state', 'Aprobado')->with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }])->get();
        return response()->json(['records' => $bills], 200);
    }

    /**
     * Obtiene un listado de las facturas rechazadas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueRejectedList()
    {
        $bills = SaleBill::where('state', 'Rechazado')->with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }])->get();
        return response()->json(['records' => $bills], 200);
    }

    /**
     * Obtiene la información de los productos o servicios a usar para el formulario
     * de facturas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function getBillProduct($product, $id){
        if ($product == 'Producto') {
            $product = SaleWarehouseInventoryProduct::find($id);
            return response()->json(['record' => $product, 'message' => 'Success'], 200);
        } else if ($product == 'Servicio') {
            $product = SaleGoodsToBeTraded::with('historyTax')->find($id);
            return response()->json(['record' => $product, 'message' => 'Success'], 200);
        } else {
            return response()->json(['record' => [], 'message' => 'Success'], 200);
        }
    }

    /**
     * Muestra una lista de los productos aprobados en el almacen
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los productos
     */
    public function getBillInventoryProducts()
    {
        $records = [];
        $inventoryProduct = SaleWarehouseMovement::where('state', 'Aprobado')
            ->with(['saleWarehouseInventoryProductMovements' => function ($query) {
                        $query->with(['saleWarehouseInventoryProduct']);
                    }])->get();

        
        array_push($records, ['id' => '', 'text' => 'Seleccione...']);

        foreach ($inventoryProduct as $invProduct){
            foreach ($invProduct->saleWarehouseInventoryProductMovements as $product) {
                array_push($records, [
                    'id' => $product->saleWarehouseInventoryProduct->id, 
                    'text' => $product->saleWarehouseInventoryProduct->SaleSettingProduct->name
                ]);
            }
        }
        return response()->json(['records' => $records], 200);
    }
}
