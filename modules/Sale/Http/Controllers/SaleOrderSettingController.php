<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleOrder;
use Modules\Sale\Models\SaleSettingProduct;

/**
 * @class SaleOrderSettingController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author jose puentes jpuentes@cenditel.gob.ve
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleOrderSettingController extends Controller
{
    use ValidatesRequests;

    /**
     * @method    index
     */
    public function index()
    {
        return view('sale::order.list');
        //return response()->json(['records' => SaleOrder::all()], 200);
    }

    /**
     * Obtiene un listado de las ordenes solicitadas con estado pendiente
     */
    public function getListPending()
    {
      $data = [];
      $records = SaleOrder::where('status', '=', 'pending')->get();
      foreach ($records as $key => $record) {
        if (!empty($record->products))  {
          $total = 0;
          $products = json_decode($record->products, true);
          foreach ($products as $id => $row) {
            $total += $row['total'];
          }
          $records[$key]->total = $total;
        }
      }

      return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene un listado de las ordenes solicitadas con estado rechazadas
     */
    public function getListRejected()
    {
      $records = SaleOrder::where('status', '=', 'rechazado')->get();
      foreach ($records as $key => $record) {
        if (!empty($record->products))  {
          $total = 0;
          $products = json_decode($record->products, true);
          foreach ($products as $id => $row) {
            $total += $row['total'];
          }
          $records[$key]->total = $total;
        }
      }
      return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene un listado de las ordenes solicitadas con estado aprobadas
     */
    public function getListApproved()
    {
      $records = SaleOrder::where('status', '=', 'aprobado')->get();
      foreach ($records as $key => $record) {
        if (!empty($record->products))  {
          $total = 0;
          $products = json_decode($record->products, true);
          foreach ($products as $id => $row) {
            $total += $row['total'];
          }
          $records[$key]->total = $total;
        }
      }
      return response()->json(['records' => $records], 200);
    }

    public function options()
    {
        //return view('sale::order.list');
        return response()->json(['records' => SaleOrder::all()], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    create
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function create()
    {
        return view('sale::order.create');
    }

    /**
     * [descripción del método]
     *
     * @method    store
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request    Objeto con información de la petición
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function store(Request $request)
    {
      $products = [];
      if (count($request->list_products)) {
        foreach ($request->list_products as $product) {
          $products[] = $product;
        }
      }

      $this->validate($request, [
        'name' => ['required', 'max:100'],
        'id_number' => ['required', 'max:100'],
        'email' => ['required', 'max:200'],
        'phone' => ['required', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        'type_person' => ['required'],
      ]);

      $order = SaleOrder::create([
        'name'        => $request->name,
        'id_number'   => $request->id_number,
        'email'       => $request->email,
        'type_person' => $request->type_person,
        'phone'       => $request->phone,
        'products'    => json_encode($products, JSON_FORCE_OBJECT),
        'status' => 'pending'
      ]);

      return response()->json(['record' => $order, 'message' => 'Success', 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * @method    show
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Muestra el formulario para editar una orden de pedido
     */
    public function edit($id)
    {
      $total = 0;
      $productos = [];
      $total_without_tax = 0;
      $record = SaleOrder::where('id', $id)->first();
      $products = json_decode($record->products, true);
      foreach ($products as $id => $row) {
        $productos[] = [
          'id' => $id,
          'sale_warehouse_inventory_product_id' => $row['inventory_product']['name'],
          'quantity' => $row['quantity'],
          'value' => $row["value"],
          'iva' => $row["product_tax_value"],
          'total' => $row['total'],
          'measurement_unit_id' => $row['measurement_unit_id'],
          'measurement_unit' => $row['measurement_unit'],
          'total_without_tax' => $row['total_without_tax'],
          'currency_id' => $row['currency']['name']
        ];
        $total += $row['total'];
        $total_without_tax += $row['total_without_tax'];
      }
      if (!empty($record->id)) {
        $record->list_products = $productos;
        $record->total_without_tax = $total_without_tax;
        $record->total = $total;
      }
      return view('sale::order.create', ['orderid' => $id, 'order' => $record]);
    }

    /**
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     */
    public function update(Request $request, $id)
    {
        $order = SaleOrder::find($id);

        $products = [];
        if ($request->list_products && !empty($request->list_products)) {
          foreach ($request->list_products as $product) {
            $products[] = $product;
          }
        }

        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'id_number' => ['required', 'max:100'],
            'email' => ['required', 'max:200'],
            'phone' => ['required', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
            'type_person' => ['required']
        ]);
        $order->name  = $request->name;
        $order->id_number = $request->id_number;
        $order->email  = $request->email;
        $order->phone  = $request->phone;
        $order->type_person  = $request->type_person;
        $order->products = json_encode($products, JSON_FORCE_OBJECT);
        $order->save();
        return response()->json(['message' => 'Success', 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    destroy
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function destroy($id)
    {
        $order = SaleOrder::find($id);
        $order->delete();
        return response()->json(['record' => $order, 'message' => 'Success', 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * @param     Integer    $type_id    Identificador único del tipo de bien
     * @return    Array      Arreglo con los registros a mostrar
     */
    public function getPriceProduct($id = null)
    {
        $product = SaleSettingProduct::find($id);
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    /**
     * Rechaza la solicitud de la orden
     */
    public function rejectedOrder(Request $request, $id)
    {
        $sale_order = SaleOrder::find($id);
        $sale_order->status = 'rechazado';
        $sale_order->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * Aprueba la solicitud de la orden
     */
    public function approvedOrder(Request $request, $id)
    {
        $sale_order = SaleOrder::find($id);
        $sale_order->status = 'aprobado';
        $sale_order->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * Obtiene la información de la orden
     */
    public function getOrderInfo($id)
    {
      $data = [];
      $total = 0;
      $total_without_tax = 0;
      $record = SaleOrder::where('id', $id)->first();
      $products = json_decode($record->products, true);
      foreach ($products as $id => $row) {
        $productos[] = [
          'id' => $id,
          'name' => $row['inventory_product']['name'],
          'quantity' => $row['quantity'],
          'price_product' => $row["total_without_tax"],
          'iva' => $row["product_tax_value"],
          'total' => $row['total'],
          'moneda' => $row['currency']['name']
        ];
        $total += $row['total'];
        $total_without_tax += $row['total_without_tax'];
      }

      if (!empty($record->id)) {
        $data = [
          'id' => $record->id,
          'name' => $record->name,
          'id_number' => $record->id_number,
          'email' => $record->email,
          'type_person' => $record->type_person,
          'phone' => $record->phone,
          'status' => $record->status,
          'created_at' => $record->created_at,
          'updated_at' => $record->updated_at,
          'list_products' => $productos,
          'total_without_tax' => $total_without_tax,
          'total' => $total,
        ];
      }
      return response()->json(['record' => $data], 200);
    }
}
