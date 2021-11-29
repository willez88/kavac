<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceBank;
use Modules\Sale\Models\SaleService;
use Modules\Sale\Models\SaleClient;
use Modules\Sale\Models\SaleGoodsToBeTraded;
use Modules\Sale\Models\SaleClientsEmail;
use Modules\Sale\Models\SaleOrder;
use Modules\Sale\Models\SaleFormPayment;
use Modules\Sale\Models\SaleOrderManagement;
use Modules\Sale\Models\SaleRegisterPayment;
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
        $records = SaleRegisterPayment::all();
        // return response()->json(['records' => SaleRegisterPayment::all()], 200);
        //return compact('records');
        return view('sale::payment.list', compact('records'));

        //$order = SaleService::where('description', 'max')->find('1');
        //return compact('order');
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
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:200']
        ]);
        $SalePayment = SaleRegisterPayment::create([
            'name' => $request->name,'description' => $request->description
        ]);
        return response()->json(['record' => $SalePayment, 'message' => 'Success'], 200);
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
     * Muestra una lista de pediros registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return Array con los pediros registrados a mostrar
     */
    public function getSaleOrderList()
    {
        return template_choices('Modules\Sale\Models\SaleOrderManagement', ['code', '-', 'name'], '', true);
    }

    /**
     * Muestra una lista de servicios registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return Array con los servicios registrados a mostrar
     */
    public function getSaleServiceList()
    {
        return template_choices('Modules\Sale\Models\SaleService', ['code', '-', 'organization'], '', true);
    }

    /**
     * Muestra una Forma de cobro registrada
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getCurrencie()
    {
        return template_choices('Modules\Sale\Models\SaleFormPayment', ['name_form_payment', '-', 'description_form_payment'], '', true);
    }

    /**
     * Obtiene los bancos registrados
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los bancos registrados
     */
    public function getSaleBank()
    {

        return template_choices('Modules\Finance\Models\FinanceBank', ['code', '-', 'name', '-', 'short_name'], '', true);
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

        $SaleService = SaleService::find($id);
        //return $SaleService['sale_goods_to_be_tradeds'];
        //return $SaleService->code;
        //$SaleGoodsToBeTraded = SaleGoodsToBeTraded::with(['unit_price','history_tax_id'])->find($SaleService->sale_goods_to_be_tradeds );

        //$saleClient = SaleClient::with(['rif', 'id_type', 'id_number', 'name', 'phones', 'saleClientsEmail'])->find($id);
        //return $saleClient;
        //return response()->json(['sale_client' => $saleClient], 200);
    }
}

