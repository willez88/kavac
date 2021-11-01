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
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleOrderSettingController extends Controller
{
    use ValidatesRequests;

    /**
     * [descripción del método]
     *
     * @method    index
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
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
      $records = SaleOrder::where('status', '=', 'pending')->get();
      return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene un listado de las ordenes solicitadas con estado rechazadas
     */
    public function getListRejected()
    {
      $records = SaleOrder::where('status', '=', 'rechazado')->get();
      return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene un listado de las ordenes solicitadas con estado aprobadas
     */
    public function getListApproved()
    {
      $records = SaleOrder::where('status', '=', 'aprobado')->get();
      return response()->json(['records' => $records], 200);
    }

    public function options()
    {
        return view('sale::order.list');
        //return response()->json(['records' => SaleOrder::all()], 200);
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

      if ($request->list_products && !empty($request->list_products)) {
        foreach ($request->list_products as $product) {
          $products[] = $product;
        }
      }

      $this->validate($request, [
        'name' => ['required', 'max:100'],
        'email' => ['required', 'max:200'],
        'phone' => ['required', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        'description' => ['required', 'max:200']
      ]);

      $order = SaleOrder::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'phone'       => $request->phone,
        'description' => $request->description,
        'products'    => json_encode($products, JSON_FORCE_OBJECT)
      ]);

      return response()->json(['record' => $order, 'message' => 'Success', 'redirect' => route('sale.order.index')], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    show
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * [descripción del método]
     *
     * @method    edit
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function edit($id)
    {
        $order = SaleOrder::find($id);
        //dd($order);
        return view('sale::order.create', compact('order'));
    }

    /**
     * [descripción del método]
     *
     * @method    update
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
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
            'email' => ['required', 'max:200'],
            'phone' => ['required', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
            'description' => ['required', 'max:200']
        ]);
        $order->name  = $request->name;
        $order->email  = $request->email;
        $order->phone  = $request->phone;
        $order->description = $request->description;
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
     * Obtiene el listado de las categorias generales de bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
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
      $record = SaleOrder::where('id', $id)->first();

      if (!empty($record->products))  {
        $products = json_decode($record->products, true);

        foreach ($products as $key => $row) {
          $product[] = [
            'id' => $key,
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'price_product' => $row['price_product'],
            'total' => $row['total']
          ];
        }
      }

      if (!empty($record->id)) {
        $data = [
          'id' => $record->id,
          'name' => $record->name,
          'email' => $record->email,
          'phone' => $record->phone,
          'description' => $record->description,
          'status' => $record->status,
          'created_at' => $record->created_at,
          'updated_at' => $record->updated_at,
          'list_products' => $product,
        ];
      }
      return response()->json(['records' => $data], 200);
    }
}
