<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

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
            'sale_discount_id' => ['required']
        ]);

        DB::transaction(function () use ($request) {
            $data_request = SaleBill::create([
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
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Obtiene un listado de las facturas registradas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $sale_bills = SaleBill::with('SaleClients')
            ->whereNotNull('sale_warehouse_id')
            ->get();
        return response()->json(['records' => $sale_bills], 200);
    }
}
