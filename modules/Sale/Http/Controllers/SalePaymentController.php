<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Institution;
use App\Repositories\ReportRepository;
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
use App\Models\HistoryTax;
use App\Rules\Rif as RifRule;
use Auth;

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

        //Establecer servicio. (true) pedido, (false).
        $order_or_service_define_attributes = ($request->sale_service_id) ? true : false;
        //valor de orden o servicio.
        $order_service_id = ($request->sale_service_id) ? $request->sale_service_id : $request->sale_order_id;

        //Si es servicio calcula el monto
        if ($order_or_service_define_attributes) {
            $SaleService = SaleService::find($request->sale_service_id);
            $sale_goods_to_be_traded_count = count($SaleService->sale_goods_to_be_traded);
            for ($i=0; $i < $sale_goods_to_be_traded_count; $i++) { 
                //Consulta valor de servicio segun el id de servicios
                $SaleGoodsToBeTraded = SaleGoodsToBeTraded::find($SaleService->sale_goods_to_be_traded[$i]);
                // valor de impuesto
                if ($SaleGoodsToBeTraded->history_tax_id) {
                    $HistoryTax = HistoryTax::find($SaleGoodsToBeTraded->history_tax_id);
                    // valor de servicio con impuesto
                    $porcentaje = ((float)$HistoryTax->percentage * $SaleGoodsToBeTraded->unit_price) / 100;
                }
                else{$porcentaje = 0;}
                //total de servicio + impuesto
                $sumatoria[$i] = $porcentaje + $SaleGoodsToBeTraded->unit_price;
            };
            $total_amount = array_sum($sumatoria); 
        }
        $this->validate($request, [
            'bank_id' => ['required'],
            'currency_id' => ['required'],
            'number_reference' => ['required'],
            'payment_date' => ['required'],
        ]);
        //anticipo
        $advance_define_attributes = ($request->advance == null) ? false : true;
        $SalePayment = SaleRegisterPayment::create([
            'order_or_service_define_attributes' => $order_or_service_define_attributes, 'order_service_id' => $order_service_id, 'total_amount' => $total_amount, 'way_to_pay' => $request->currency_id, 'banking_entity' => $request->bank_id, 'reference_number' => $request->number_reference, 'payment_date' => $request->payment_date, 'advance_define_attributes' => $advance_define_attributes
        ]);


        if ($advance_define_attributes == true) {
            /**
             * [$pdf base para generar el pdf del recibo de pago]
             * @var [Modules\Accounting\Pdf\Pdf]
             */
            $pdf = new ReportRepository();

            /*
             *  Definicion de las caracteristicas generales de la página pdf
             */
            $institution = null;
            $is_admin = auth()->user()->isAdmin();

            if (!$is_admin && $user_profile && $user_profile['institution']) {
                $institution = Institution::find($user_profile['institution']['id']);
            } else {
                $institution = '';
            }

            $pdf->setConfig(['institution' => Institution::first()]);
            $pdf->setHeader('Recibo de Pago');
            $pdf->setFooter();
            $pdf->setBody('sale::pdf.payment_advance_receipt', true, [
                'pdf'         => $pdf,
                'SalePayment' => $SalePayment
            ]);
        }
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
     * Obtiene un listado de los pagos registrados
     */
    public function vueList()
    {

        $saleservice = SaleService::with(['SaleGoodsToBeTraded'])
        ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
        ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
        ->select('sale_register_payments.id as id', 'code', 'payment_date', 'name', 'total_amount', 'reference_number', 'sale_goods_to_be_traded', 'order_or_service_define_attributes', 'type_person_juridica', 'name', 'id_number', 'organization', 'rif', 'phones', 'emails', 'payment_date', 'payment_refuse')
        ->orderBy('id')
        ->get();

        /*
        $x6 = SaleService::with(['jose'])
                    ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
                    ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
                    ->get();*/

        $values_all = [];
        foreach ($saleservice as $value) {
            $bolean = true;
            if ($bolean == true && $value->order_or_service_define_attributes == true) {
                $value_2 = $value;
                array_push($values_all,$value_2);
            }
        }
        /*
        foreach ($x6 as $value) {
            $bolean = false;
            if ($bolean == false && $value->order_or_service_define_attributes == false) {
                $value_2 = $value;
                array_push($values_all,$value_2);
            }
        }
        */
        return response()->json(['records' => collect($values_all)], 200);



    }

    public function pending()
    {
            $saleservice = SaleService::with(['SaleGoodsToBeTraded'])
            ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
            ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
            ->select('sale_register_payments.id as id', 'code', 'payment_date', 'name', 'total_amount', 'reference_number', 'sale_goods_to_be_traded', 'order_or_service_define_attributes', 'type_person_juridica', 'name', 'id_number', 'organization', 'rif', 'phones', 'emails', 'payment_date', 'payment_refuse')
            ->orderBy('id')            
            ->where('payment_approve', '=', false)
            ->get();
            /*
            $x6 = SaleService::with(['jose'])
                        ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
                        ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
                        ->get();*/

            $values_all = [];
            foreach ($saleservice as $value) {
                $bolean = true;
                if ($bolean == true && $value->order_or_service_define_attributes == true) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            /*
            foreach ($x6 as $value) {
                $bolean = false;
                if ($bolean == false && $value->order_or_service_define_attributes == false) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            */
            return response()->json(['records' => collect($values_all)], 200);

    }

    public function payment_approve()
    {
            $saleservice = SaleService::with(['SaleGoodsToBeTraded'])
            ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
            ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
            ->select('sale_register_payments.id as id', 'code', 'payment_date', 'name', 'total_amount', 'reference_number', 'sale_goods_to_be_traded', 'order_or_service_define_attributes', 'type_person_juridica', 'name', 'id_number', 'organization', 'rif', 'phones', 'emails', 'payment_date', 'payment_refuse')
            ->orderBy('id')            
            ->where('payment_approve', '=', true)
            ->get();

            /*
            $x6 = SaleService::with(['jose'])
                        ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
                        ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
                        ->get();*/

            $values_all = [];
            foreach ($saleservice as $value) {
                $bolean = true;
                if ($bolean == true && $value->order_or_service_define_attributes == true) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            /*
            foreach ($x6 as $value) {
                $bolean = false;
                if ($bolean == false && $value->order_or_service_define_attributes == false) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            */
           
            return response()->json(['records' => collect($values_all)], 200);
    }

    public function advance_define_attributes_approve()
    {
            $saleservice = SaleService::with(['SaleGoodsToBeTraded'])
            ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
            ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
            ->select('sale_register_payments.id as id', 'code', 'payment_date', 'name', 'total_amount', 'reference_number', 'sale_goods_to_be_traded', 'order_or_service_define_attributes', 'type_person_juridica', 'name', 'id_number', 'organization', 'rif', 'phones', 'emails', 'payment_date', 'payment_refuse')
            ->orderBy('id')            
            ->where('advance_define_attributes', '=', true)
            ->where('payment_approve', '=', true)
            ->get();
            /*
            $x6 = SaleService::with(['jose'])
                        ->join("sale_register_payments","sale_services.id","=","sale_register_payments.order_service_id")
                        ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
                        ->get();*/

            $values_all = [];
            foreach ($saleservice as $value) {
                $bolean = true;
                if ($bolean == true && $value->order_or_service_define_attributes == true) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            /*
            foreach ($x6 as $value) {
                $bolean = false;
                if ($bolean == false && $value->order_or_service_define_attributes == false) {
                    $value_2 = $value;
                    array_push($values_all,$value_2);
                }
            }
            */

            return response()->json(['records' => collect($values_all)], 200);

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
        
        $payment = SaleRegisterPayment::find($id);
        //return $payment;
        return view('sale::payment.create', compact("payment"));
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
        dd($id) ;

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
        $payment = SaleRegisterPayment::find($id);
        $payment->delete();
        return response()->json(['record' => $payment, 'message' => 'Success'], 200);
    }
   
    /**
     * Vizualiza información de una solicitud de pagos
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @param  Integer $id Identificador único de la solicitud de almacén
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function vueInfo($id)
    {
/*
        $payment = SaleService::with(['SaleGoodsToBeTraded'])
                    ->join("sale_register_payments","sale_services.".$id."","=","sale_register_payments.order_service_id")
                    ->join("sale_clients","sale_services.sale_client_id","=","sale_clients.id")
                    ->first();
*/
        $payment = SaleRegisterPayment::with('saleService')->where('id', $id)->get();

        return response()->json(['record' => $payment], 200);
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
        //datos del cliente
        $saleClients = SaleClient::find($SaleService->sale_client_id);
        //email
        $saleClientsEmail = SaleClientsEmail::find($SaleService->sale_client_id);
        //teléfono
        $saleClientsPhone = Phone::find($SaleService->sale_client_id);
        $sale_goods_to_be_traded_count = count($SaleService->sale_goods_to_be_traded);
        for ($i=0; $i < $sale_goods_to_be_traded_count; $i++) { 
            //Consulta valor de servicio segun el id de servicios
            $SaleGoodsToBeTraded = SaleGoodsToBeTraded::find($SaleService->sale_goods_to_be_traded[$i]);
            // valor de impuesto
            if ($SaleGoodsToBeTraded->history_tax_id) {
                $HistoryTax = HistoryTax::find($SaleGoodsToBeTraded->history_tax_id);
                // valor de servicio con impuesto
                $porcentaje = ((float)$HistoryTax->percentage * $SaleGoodsToBeTraded->unit_price) / 100;
            }
            else{$porcentaje = 0;}
            //total de servicio + impuesto
            $sumatoria[$i] = $porcentaje + $SaleGoodsToBeTraded->unit_price;
        };
        $total = array_sum($sumatoria);  
        $value = array('code' =>  $SaleService->code, 'total' =>  $total, 'name' =>  $saleClients->name, 'idntifiaction' =>  $saleClients->id_type, 'identification_number' =>  $saleClients->id_number, 'rif' =>  $saleClients->rif, 'email' =>  $saleClientsEmail->email, 'phone_extension' =>  $saleClientsPhone->extension, 'phone_area_code' =>  $saleClientsPhone->area_code, 'total' =>  $total, 'phone_number' =>  $saleClientsPhone->number);
        return response()->json(['sale_service' => $value], 200);
    }

    /**
     * Aprueba la solicitud realizada
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los clientes
     */
    public function approvedPayment($id)
    {
        $payment = SaleRegisterPayment::find($id);
        $payment->payment_approve = true;
        $payment->save();

        return response()->json(['record' => $payment, 'message' => 'Success'], 200);
    }
    /**
     * Rechaza la solicitud realizada
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los clientes
     */
        public function refusePayment($id)
    {
        $payment = SaleRegisterPayment::find($id);
        $payment->payment_refuse = true;
        $payment->save();

        return response()->json(['record' => $payment, 'message' => 'Success'], 200);
    }

    /**
     * gerena archivo Pdf
     *
     * @author Miguel Narvaez <mnarvaezcenditel.gob.ve>
     */
        public function PdfGenerator(Request $request, $id)
    {

        $SalePayment = SaleRegisterPayment::find($id);

        /**
         * [$pdf base para generar el pdf del recibo de pago]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = null;
        $is_admin = auth()->user()->isAdmin();

        if (!auth()->user()->isAdmin()) {
            if ($requirement && $requirement->queryAccess($user_profile['institution']['id'])) {
                return view('errors.403');
            }
        }

        if (!$is_admin && $user_profile && $user_profile['institution']) {
            $institution = Institution::find($user_profile['institution']['id']);
        } else {
            $institution = '';
        }

        $pdf->setConfig(['institution' => Institution::first()]);
        $pdf->setHeader('Pago Registrado');
        $pdf->setFooter();
        $pdf->setBody('sale::pdf.payment_record_information', true, [
            'pdf'         => $pdf,
            'SalePayment' => $SalePayment
        ]);
    }
}