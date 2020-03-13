<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchaseBaseBudget;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;

use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;
use Modules\Purchase\Models\Currency;

use Modules\Purchase\Models\PurchaseSupplier;


use App\Repositories\UploadDocRepository;

use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

use App\Models\ExchangeRate;

class PurchaseQuotationController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('purchase::quotation.index', [
            'records' => PurchaseQuotation::with('purchaseSupplier', 'currency', 'relatable')
            ->orderBy('id', 'ASC')->get()
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

        $record_base_budgets = PurchaseBaseBudget::with(
            'currency',
            'purchaseRequirement.contratingDepartment',
            'purchaseRequirement.userDepartment',
            'relatable.purchaseRequirementItem.purchaseRequirement'
        )->where('status', 'WAIT_QUOTATION')->orderBy('id', 'ASC')->get();

        return view('purchase::quotation.form', [
            'record_base_budgets' => $record_base_budgets,
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
        $code = $this->generateCodeAvailable();
        $purchase_quotation = PurchaseQuotation::create([
            'code'                 => $code,
            'purchase_supplier_id' => $request->purchase_supplier_id,
            'currency_id'          => $request->currency_id,
            'status'               => 'QUOTED',
            'subtotal'             => $request->subtotal,
        ]);

        foreach (json_decode($request['record_list'], true) as $record) {
            $base_budget = PurchaseBaseBudget::with('purchaseRequirement')->find($record['id']);

            $requirement = PurchaseRequirement::find($base_budget['purchaseRequirement']['id']);
            $requirement->requirement_status = 'QUOTED';
            $requirement->save();

            $purchase_quotation->purchase_base_budget_id = $base_budget->id;
            $purchase_quotation->save();

            foreach ($record['relatable'] as $item) {
                PurchasePivotModelsToRequirementItem::create([
                    'purchase_requirement_item_id' => $item['id'],
                    'relatable_type'               => PurchaseQuotation::class,
                    'relatable_id'                 => $purchase_quotation->id,
                    'unit_price'                   => $item['unit_price']
                ]);
            }
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
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * [generateCodeAvailable genera el código disponible]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return string [código que se asignara]
     */
    public function generateCodeAvailable()
    {
        $codeSetting = CodeSetting::where('table', 'purchase_quotations')
                                    ->first();

        if (!$codeSetting) {
            $codeSetting = CodeSetting::where('table', 'purchase_quotations')
                                    ->first();
        }

        if ($codeSetting) {
            $code  = generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                PurchaseQuotation::class,
                $codeSetting->field
            );
        } else {
            $code = 'error al generar código de referencia';
        }

        return $code;
    }
}
