<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Sale\Models\SaleBill;
use Modules\Sale\Models\SaleBillInventoryProduct;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;

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
        $this->validate($request, [
            'sale_client_id.*' => ['required'],
            'sale_warehouse_id' => ['required'],
            'sale_payment_method_id' => ['required'],
            'currency_id' => ['required'],
            'sale_discount_id' => ['nullable']
        ]);

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
            $data_request = SaleBill::create([
                'code' => $code,
                'state' => 'Pendiente',
                'sale_client_id' => $request->input('sale_client_id'),
                'sale_warehouse_id' => $request->input('sale_warehouse_id'),
                'sale_payment_method_id' => $request->input('sale_payment_method_id'),
                'currency_id' => $request->input('currency_id'),
                'sale_discount_id' => $request->input('sale_discount_id')
            ]);

            foreach ($request->sale_setting_products as $product) {
                $inventory_product = SaleWarehouseInventoryProduct::find($product['id']);
                if (!is_null($inventory_product)) {
                    $exist_real = $inventory_product->exist - $inventory_product->reserved;
                    if ($exist_real >= $product['requested']) {
                        SaleBillInventoryProduct::create([
                            'sale_warehouse_inventory_product_id' => $inventory_product->id,
                            'sale_bill_id' => $data_request->id,
                            'quantity' => $product['requested'],
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
        $this->validate($request, [
            'sale_client_id.*' => ['required'],
            'sale_warehouse_id' => ['required'],
            'sale_payment_method_id' => ['required'],
            'currency_id' => ['required'],
            'sale_discount_id' => ['nullable']
        ]);

        $sale_bills->sale_client_id = $request->input('sale_client_id');
        $sale_bills->sale_warehouse_id = $request->input('sale_warehouse_id');
        $sale_bills->sale_payment_method_id = $request->input('sale_payment_method_id');
        $sale_bills->currency_id = $request->input('currency_id');
        $sale_bills->sale_discount_id = $request->input('sale_discount_id');
        $sale_bills->save();

        $update = now();

        /** Se agregan los nuevos elementos a la solicitud */
        foreach ($request->sale_setting_products as $product) {
            $inventory_product = SaleWarehouseInventoryProduct::find($product['id']);
            if (!is_null($inventory_product)) {
                $exist_real = $inventory_product->exist - $inventory_product->reserved;
                if ($exist_real >= $product['requested']) {
                    $old_request = SaleBillInventoryProduct::where(
                        'sale_bill_id',
                        $sale_bills->id
                    )
                    ->where('sale_warehouse_inventory_product_id', $inventory_product->id)->first();
                    if (!is_null($old_request)) {
                        $old_request->quantity = $product['requested'];
                        $old_request->updated_at = $update;
                        $old_request->save();
                    } else {
                        SaleBillInventoryProduct::updateOrCreate([
                            'sale_warehouse_inventory_product_id' => $inventory_product->id,
                            'sale_bill_id' => $sale_bills->id,
                            'quantity' => $product['requested'],
                            'updated_at' => $update,
                        ]);
                    }
                } else {
                    /** Si la exitencia del producto es menor que lo que se solicita
                     *  se revierten los cambios
                     */
                    DB::rollback();
                }
            }
        };

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

        $bill_inventory_products = $sale_bills->SaleBillInventoryProduct;

        foreach ($bill_inventory_products as $bill_inventory_product) {
            $sale_warehouse_inventory_product = $bill_inventory_product->SaleWarehouseInventoryProduct;
            $exist = $sale_warehouse_inventory_product->exist;
            $exist -= $bill_inventory_product->quantity;
            $sale_warehouse_inventory_product->exist = $exist;
            $sale_warehouse_inventory_product->save();
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
        $sale_bills = SaleBill::find($id);
        $sale_bills->state = 'Rechazado';
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
        return response()->json(['records' => SaleBill::where('id', $id)->with(
            [
                'saleClient',
                'saleWarehouse',
                'salePaymentMethod',
                'saleDiscount',
                'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleWarehouseInventoryProduct' => function ($query){
                            $query->with('saleSettingProduct');
                        }]);
                    }
            ]
        )->first()], 200);
    }

    /**
     * Obtiene un listado de las facturas registradas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $sale_bills = SaleBill::with(['saleClient', 'SaleBillInventoryProduct' => 
            function ($query) {
                $query->with('SaleWarehouseInventoryProduct');
            }])
            ->get();
        return response()->json(['records' => $sale_bills], 200);
    }

    /**
     * Obtiene un listado de las facturas aprobadas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueApprovedList($state)
    {
        $sale_bills = SaleBill::with(['saleClient', 'SaleBillInventoryProduct' =>
            function ($query) {
                $query->with('SaleWarehouseInventoryProduct');
            }])
            ->where('state', $state)->get();
        return response()->json(['records' => $sale_bills], 200);
    }
}
