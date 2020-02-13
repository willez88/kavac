<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseRequirement;

use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;
use Modules\Purchase\Models\Currency;

use Modules\Purchase\Models\PurchaseSupplier;

use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Repositories\UploadDocRepository;

use App\Models\ExchangeRate;

class PurchaseOrderController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('purchase::purchase_order.index', [
            'records' => PurchaseOrder::with('purchaseSupplier', 'currency')->orderBy('id', 'ASC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
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
            'purchaseSupplierType',
            'fiscalYear',
            'userDepartment',
            'purchaseRequirementItems.measurementUnit',
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
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file'                 => 'required|mimes:pdf',
            'purchase_supplier_id' => 'required|integer',
            'currency_id'          => 'required|integer',
        ], [
            'file.required'                 => 'El archivo de proforma / cotización es obligatorio.',
            'file.mimes'                    => 'El archivo de proforma / cotización debe estar en formato pdf.',
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
        ]);
        foreach (json_decode($request['requirement_list_deleted'], true) as $item) {
            $requirement = PurchaseRequirement::find($item['id']);
            $requirement->purchase_order_id = null;
            $requirement->save();
        }

        foreach (json_decode($request['requirement_list'], true) as $item) {
            $requirement = PurchaseRequirement::find($item['id']);
            $requirement->purchase_order_id = $purchase_order->id;
            $requirement->save();
        }
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $record_edit = PurchaseOrder::with(
            'purchaseSupplier',
            'currency',
            'purchaseRequirement.purchaseRequirementItems.measurementUnit'
        )->find($id);

        $suppliers  = template_choices('Modules\Purchase\Models\PurchaseSupplier', ['rif','-', 'name'], [], true);
        
        $currencies = template_choices('Modules\Purchase\Models\Currency', ['name'], [], true);
        
        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        $taxUnit    = TaxUnit::where('active', true)->first();
        
        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'purchaseSupplierType',
            'fiscalYear',
            'userDepartment',
            'purchaseRequirementItems.measurementUnit',
            'purchaseBaseBudget.currency'
        )->where('requirement_status', 'PROCESSED')
        ->orderBy('id', 'ASC')->get();

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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function updatePurchaseOrder(Request $request, $id)
    {
        $this->validate($request, [
            'file'                 => 'required|mimes:pdf',
            'purchase_supplier_id' => 'required|integer',
            'currency_id'          => 'required|integer',
        ], [
            'file.required'                 => 'El archivo de proforma / cotización es obligatorio.',
            'file.mimes'                    => 'El archivo de proforma / cotización debe estar en formato pdf.',
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

        $purchase_order->purchase_supplier_id = $request->purchase_supplier_id;
        $purchase_order->currency_id          = $request->currency_id;
        $purchase_order->save();

        foreach (json_decode($request['requirement_list_deleted'], true) as $item) {
            $requirement = PurchaseRequirement::find($item['id']);
            $requirement->purchase_order_id = null;
            $requirement->save();
        }

        foreach (json_decode($request['requirement_list'], true) as $item) {
            $requirement = PurchaseRequirement::find($item['id']);
            $requirement->purchase_order_id = $purchase_order->id;
            $requirement->save();
        }
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        PurchaseOrder::find($id)->delete();
        foreach (PurchaseRequirement::where('purchase_order_id', $id)->orderBy('id', 'ASC')->get() as $record) {
            $record->purchase_order_id = null;
            $record->save();
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
