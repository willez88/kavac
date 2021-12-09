<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;

use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;


use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Repositories\UploadDocRepository;

use App\Models\ExchangeRate;

class PurchaseOrderController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('purchase::purchase_order.index', [
            'records' => PurchaseOrder::with('purchaseSupplier', 'currency', 'relatable')->orderBy('id', 'ASC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $suppliers  = template_choices('Modules\Purchase\Models\PurchaseSupplier', ['rif','-', 'name'], [], true);

        $currencies = template_choices('Modules\Purchase\Models\Currency', ['name'], [], true);

        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        $taxUnit    = TaxUnit::where('active', true)->first();

        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirementItems.warehouseProduct.measurementUnit',
            'purchaseBaseBudget.currency'
        )->where('requirement_status', 'PROCESSED')
        ->orderBy('id', 'ASC')->get();
        return view('purchase::purchase_order.form', [
            'requirements' => $requirements,
            'currencies'   => json_encode($currencies),
            'tax'          => json_encode($historyTax),
            'tax_unit'     => json_encode($taxUnit),
            'suppliers'    => json_encode($suppliers),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'file'                 => 'required|mimes:pdf',
            'purchase_supplier_id' => 'required|integer',
            'currency_id'          => 'required|integer',
        ], [
            // 'file.required'                 => 'El archivo de proforma / cotización es obligatorio.',
            // 'file.mimes'                    => 'El archivo de proforma / cotización debe estar en formato pdf.',
            'purchase_supplier_id.required' => 'El campo proveedor es obligatorio.',
            'purchase_supplier_id.integer'  => 'El campo proveedor debe ser numerico.',
            'currency_id.required'          => 'El campo de tipo de moneda es obligatorio.',
            'currency_id.integer'           => 'El campo de tipo de moneda debe ser numerico.',
        ]);

        // // Se guarda el archivo
        // $file = new UploadDocRepository();
        // $file->uploadDoc(
        //     $request->file('file'),
        //     'documents'
        // );

        $purchase_order = PurchaseOrder::create([
            'purchase_supplier_id' => $request->purchase_supplier_id,
            'currency_id'          => $request->currency_id,
            'subtotal'             => $request->subtotal,
        ]);

        foreach (json_decode($request['requirement_list'], true) as $req) {
            $requirement = PurchaseRequirement::find($req['id']);
            $requirement->requirement_status = 'BOUGHT';
            $requirement->purchase_order_id = $purchase_order->id;
            $requirement->save();

            foreach ($req['purchase_requirement_items'] as $item) {
                PurchasePivotModelsToRequirementItem::create([
                    'purchase_requirement_item_id' => $item['id'],
                    'relatable_type'               => PurchaseOrder::class,
                    'relatable_id'                 => $purchase_order->id,
                    'unit_price'                   => $item['unit_price']
                ]);
            }
        }
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit($id)
    {
        $record_edit = PurchaseOrder::with(
            'purchaseSupplier',
            'currency',
            'purchaseRequirement.purchaseRequirementItems.measurementUnit',
            'purchaseRequirement.contratingDepartment',
            'purchaseRequirement.userDepartment',
            'purchaseRequirement.purchaseBaseBudget.currency',
            'relatable'
        )->find($id);

        $suppliers  = template_choices('Modules\Purchase\Models\PurchaseSupplier', ['rif','-', 'name'], [], true);

        $currencies = template_choices('Modules\Purchase\Models\Currency', ['name'], [], true);

        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        $taxUnit    = TaxUnit::where('active', true)->first();

        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirementItems.measurementUnit',
            'purchaseBaseBudget.currency'
        )->where('requirement_status', 'PROCESSED')
        ->orderBy('id', 'ASC')->get();
        $requirements = $requirements->concat($record_edit->purchaseRequirement);

        return view('purchase::purchase_order.form', [
            'requirements' => $requirements,
            'currencies'   => json_encode($currencies),
            'tax'          => json_encode($historyTax),
            'tax_unit'     => json_encode($taxUnit),
            'suppliers'    => json_encode($suppliers),
            'record_edit'  => $record_edit
        ]);
    }

    /**
     * [updatePurchaseOrder the specified resource in storage]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request  Objeto con información de la petición
     * @param  integer  $id      Identificador de la orden de compra
     * @return JsonResponse
     */
    public function updatePurchaseOrder(Request $request, $id)
    {
        $this->validate($request, [
            // 'file'                 => 'required|mimes:pdf',
            'purchase_supplier_id' => 'required|integer',
            'currency_id'          => 'required|integer',
        ], [
            // 'file.required'                 => 'El archivo de proforma / cotización es obligatorio.',
            // 'file.mimes'                    => 'El archivo de proforma / cotización debe estar en formato pdf.',
            'purchase_supplier_id.required' => 'El campo proveedor es obligatorio.',
            'purchase_supplier_id.integer'  => 'El campo proveedor debe ser numerico.',
            'currency_id.required'          => 'El campo de tipo de moneda es obligatorio.',
            'currency_id.integer'           => 'El campo de tipo de moneda debe ser numerico.',
        ]);

        // // Se guarda el archivo
        // $file = new UploadDocRepository();
        // $file->uploadDoc(
        //     $request->file('file'),
        //     'documents'
        // );

        $purchase_order = PurchaseOrder::find($id);

        if ($purchase_order) {
            $purchase_order->purchase_supplier_id = $request->purchase_supplier_id;
            $purchase_order->currency_id          = $request->currency_id;
            $purchase_order->subtotal             = $request->subtotal;
            $purchase_order->save();

            foreach (json_decode($request['list_to_delete'], true) as $requirement) {
                // trae requerimiento
                $rq = PurchaseRequirement::find($requirement['id']);

                if ($rq) {
                    $rq->requirement_status      = 'PROCESSED';
                    $rq->purchase_base_budget_id = null;
                    $rq->save();

                    foreach ($requirement['purchase_requirement_items'] as $item) {
                        $r = PurchasePivotModelsToRequirementItem::where('purchase_requirement_item_id', $item['id'])
                                                                    ->fisrt();
                        if ($r) {
                            $r->delete();
                        }
                    }
                }
            }

            foreach (json_decode($request['requirement_list'], true) as $requirement) {
                $rq = PurchaseRequirement::find($requirement['id']);
                if ($rq) {
                    $rq->requirement_status = 'BOUGHT';
                    $rq->purchase_order_id = $purchase_order->id;
                    $rq->save();

                    foreach ($requirement['purchase_requirement_items'] as $item) {
                        PurchasePivotModelsToRequirementItem::create([
                            'purchase_requirement_item_id' => $item['id'],
                            'relatable_type'               => PurchaseOrder::class,
                            'relatable_id'                 => $purchase_order->id,
                            'unit_price'                   => $item['unit_price']
                        ]);
                    }
                }
            }
        }
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $purchase_order = PurchaseOrder::find($id);
        if ($purchase_order) {
            foreach (PurchaseRequirement::where('purchase_order_id', $id)->orderBy('id', 'ASC')->get() as $record) {
                $record->requirement_status = 'PROCESSED';
                $record->purchase_order_id = null;
                $record->save();
            }
            foreach (PurchasePivotModelsToRequirementItem::where('relatable_id', $id)
                        ->orderBy('id', 'ASC')->get() as $record) {
                $record->delete();
            }
            $purchase_order->delete();
        }
        return response()->json([
            'message' => 'Success',
        ], 200);
    }

    public function getConvertion($currency_id, $base_budget_currency_id)
    {
        $record = ExchangeRate::where('active', true)
                        ->where('start_at', '>=', date('Y-m-d'))
                        ->where('end_at', '<=', date('Y-m-d'))
                        ->whereIn('to_currency_id', [$base_budget_currency_id, $currency_id])
                        ->whereIn('from_currency_id', [$base_budget_currency_id, $currency_id])
                         ->orderBy('end_at', 'DESC')->first();

        return response()->json(['record'=> $record]);
    }
}
