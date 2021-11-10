<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleService;
use Modules\Sale\Models\SaleClient;
use Modules\Sale\Models\SaleGoodsToBeTraded;
use Modules\Sale\Models\SaleClientsEmail;
use Modules\Sale\Models\SaleOrder;
use Modules\Sale\Models\SaleOrderManagement;
use App\Models\Phone;
use App\Rules\Rif as RifRule;

/**
 * @class SalePaymentController
 * @brief Pagos
 *
 * Registros y aprobación de pagos.
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SalePaymentController extends Controller
{
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
        return view('sale::payment.list');
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
        return view('sale::payment.create');
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
        //
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
    //    return view('sale::show');
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
    //    return view('sale::edit');
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
        //
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
        //
    }
    
    /**
     * Obtiene los servicios registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los servicios
     */
    public function getSaleService($id)
    {
        $saleService = SaleService::with(['id', 'code', 'status', 'sale_goods_to_be_traded', 'sale_client_id'])->find($id);
        return response()->json(['sale_service' => $saleService], 200);
    }

    /**
     * Obtiene los Datos de la solicitud de servicios registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la solicitud de servicios
     */
    public function getSaleGoodsToBeTraded($id)
    {
        $sale_goods_to_be_traded = SaleGoodsToBeTraded::with(['name', 'description', 'unit_price', 'currency_id', 'measurement_unit_id', 'department_id', 'sale_type_good_id', 'payroll_staff_id' ])->find($id);
        return response()->json(['sale_goods_to_be_traded' => $sale_goods_to_be_traded], 200);
    }

    /**
     * Obtiene los clientes registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los clientes
     */
    public function getSaleClient($id)
    {
        $saleClient = SaleClient::with(['rif', 'id_type', 'id_number', 'name', 'phones', 'saleClientsEmail'])->find($id);
        return response()->json(['sale_client' => $saleClient], 200);
    }
}
