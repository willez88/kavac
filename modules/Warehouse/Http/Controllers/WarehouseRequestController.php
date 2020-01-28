<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseInventoryProductRequest;
use Modules\Warehouse\Models\WarehouseRequest;

/**
 * @class WarehouseRequestController
 * @brief Controlador de solicitudes de almacén
 *
 * Clase que gestiona las solicitudes de los productos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseRequestController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.request.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.request.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.request.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.request.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las solicitudes de almacén registradas
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return view('warehouse::requests.list');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('warehouse::requests.create');
    }

    /**
     * Valida y registra una nueva solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'warehouse_products.*' => ['required'],
            'budget_specific_action_id' => ['required'],
            'department_id' => ['required'],
            'motive' => ['required']

        ]);

        $codeSetting = CodeSetting::where('table', 'warehouse_requests')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('warehouse.setting.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );


        DB::transaction(function () use ($request, $code) {
            $data_request = WarehouseRequest::create([
                'code' => $code,
                'state' => 'Pendiente',
                'motive' => $request->input('motive'),
                'budget_specific_action_id' => $request->input('budget_specific_action_id'),
                'department_id' => $request->input('department_id'),
                'payroll_staff_id' => $request->input('payroll_staff_id')
            ]);

            foreach ($request->warehouse_products as $product) {
                $inventory_product = WarehouseInventoryProduct::find($product['id']);
                if (!is_null($inventory_product)) {
                    $exist_real = $inventory_product->exist - $inventory_product->reserved;
                    if ($exist_real >= $product['requested']) {
                        WarehouseInventoryProductRequest::create([
                            'warehouse_inventory_product_id' => $inventory_product->id,
                            'warehouse_request_id' => $data_request->id,
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
        $warehouse_request = WarehouseRequest::where('code', $code)->first();
        if (is_null($warehouse_request)) {
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
        return response()->json(['result' => true, 'redirect' => route('warehouse.request.index')], 200);
    }

    /**
     * Muestra el formulario para editar una solicitud de  almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        return view('warehouse::requests.create', compact('warehouse_request'));
    }

    /**
     * Actualiza la información de las solicitudes de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        $this->validate($request, [
            'warehouse_products.*' => ['required'],
            'budget_specific_action_id' => ['required'],
            'department_id' => ['required'],
            'motive' => ['required']

        ]);
            
        DB::transaction(function () use ($request, $warehouse_request) {
            $warehouse_request->motive = $request->input('motive');
            $warehouse_request->budget_specific_action_id = $request->input('budget_specific_action_id');
            $warehouse_request->department_id = $request->input('department_id');
            $warehouse_request->save();

            $update = now();

            /** Se agregan los nuevos elementos a la solicitud */
            foreach ($request->warehouse_products as $product) {
                $inventory_product = WarehouseInventoryProduct::find($product['id']);
                if (!is_null($inventory_product)) {
                    $exist_real = $inventory_product->exist - $inventory_product->reserved;
                    if ($exist_real >= $product['requested']) {
                        $old_request = WarehouseInventoryProductRequest::where(
                            'warehouse_request_id',
                            $warehouse_request->id
                        )
                        ->where('warehouse_inventory_product_id', $inventory_product->id)->first();
                        if (!is_null($old_request)) {
                            $old_request->quantity = $product['requested'];
                            $old_request->updated_at = $update;
                            $old_request->save();
                        } else {
                            WarehouseInventoryProductRequest::create([
                                'warehouse_inventory_product_id' => $inventory_product->id,
                                'warehouse_request_id' => $warehouse_request->id,
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
            $warehouse_request_products = WarehouseInventoryProductRequest::where(
                'warehouse_request_id',
                $warehouse_request->id
            )->where('updated_at', '!=', $update)->get();

            foreach ($warehouse_request_products as $warehouse_request_product) {
                $warehouse_request_product->delete();
            }
        });
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('warehouse.request.index')], 200);
    }

    /**
     * Confirma la entrega de una solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function confirmRequest(Request $request, $id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        if (!is_null($warehouse_request)) {
            $warehouse_request->observations = !empty($request->observations)?$request->observations:'N/A';
            $warehouse_request->delivered = true;
            $warehouse_request->state = 'Entregado';
            $warehouse_request->delivery_date = now();
            $warehouse_request->save();
            $request->session()->flash('message', ['type' => 'update']);
            return response()->json(['result' => true, 'redirect' => route('warehouse.request.index')], 200);
        }
    }

    /**
     * Rechaza la solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function rejectedRequest(Request $request, $id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        $warehouse_request->state = 'Rechazado';
        $warehouse_request->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('warehouse.request.index')], 200);
    }

    /**
     * Aprueba la solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function approvedRequest(Request $request, $id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        DB::transaction(function () use ($warehouse_request) {
            $warehouse_request->state = 'Aprobado';
            $warehouse_request->save();
            $warehouse_request_products = $warehouse_request->WarehouseInventoryProductRequests;
            foreach ($warehouse_request_products as $warehouse_request_product) {
                $warehouse_inventory_product =
                    WarehouseInventoryProduct::find($warehouse_request_product->warehouse_inventory_product_id);
                if (!is_null($warehouse_inventory_product)) {
                    $exist_real =
                        $warehouse_inventory_product->exist - $warehouse_inventory_product->reserved;
                    if ($exist_real < $warehouse_request_product->quantity) {
                        /** Si la exitencia del producto es menor que lo que solicitamos
                         *  se revierten los cambios
                         */
                        DB::rollback();
                    } else {
                        if ($warehouse_inventory_product->reserved > 0) {
                            $warehouse_inventory_product->reserved +=
                                $warehouse_request_product->quantity;
                            $warehouse_inventory_product->save();
                        } else {
                            $warehouse_inventory_product->reserved =
                                $warehouse_request_product->quantity;
                            $warehouse_inventory_product->save();
                        }
                    };
                } else {
                    /** Si no existe el registro en inventario
                     *  se revierten los cambios
                     */
                    DB::rollback();
                }
            }
        });
        if ($warehouse_request->state != 'Aprobado') {
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
            $request->session()->flash('message', ['type' => 'update']);
        }
        return response()->json(['result' => true, 'redirect' => route('warehouse.request.index')], 200);
    }

    /**
     * Elimina una solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $warehouse_request = WarehouseRequest::find($id);
        $warehouse_request->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene la información de los productos inventariados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function getInventoryProduct()
    {
        $warehouse_product = WarehouseInventoryProduct::with(['warehouseProductValues' => function ($query) {
            $query->with('warehouseProductAttribute');
        }, 'currency', 'warehouseProduct', 'warehouseInstitutionWarehouse' => function ($query) {
            $query->with('warehouse');
        }, 'warehouseInventoryRule'])->get();

        return response()->json(['records' => $warehouse_product], 200);
    }

    /**
     * Vizualiza información de una solicitud de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function vueInfo($id)
    {
        return response()->json(['records' => WarehouseRequest::where('id', $id)->with(
            [
                'budgetSpecificAction',
                'department',
                'warehouseInventoryProductRequests' => function ($query) {
                    $query->with(['warehouseInventoryProduct' => function ($query) {
                        $query->with(['warehouseProduct' => function ($query) {
                            $query->with('measurementUnit');
                        }, 'currency']);
                    }]);
                }
            ]
        )->first()], 200);
    }

    /**
     * Obtiene un listado de las solicitudes de almacén registradas
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $warehouse_requests = WarehouseRequest::with('department')
            ->whereNotNull('budget_specific_action_id')
            ->get();
        return response()->json(['records' => $warehouse_requests], 200);
    }

    /**
     * Obtiene un listado de las solicitudes de almacén pendientes
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vuePendingList()
    {
        $warehouse_requests = WarehouseRequest::with('department', 'payrollStaff')
            ->get();
        return response()->json(['records' => $warehouse_requests], 200);
    }
}
