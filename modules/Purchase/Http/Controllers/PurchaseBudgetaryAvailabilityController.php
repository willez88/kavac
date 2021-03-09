<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\FiscalYear;
use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Purchase\Models\PurchaseBaseBudget;

use Modules\Purchase\Models\BudgetCompromise;
use Modules\Purchase\Models\BudgetCompromiseDetail;
use Modules\Purchase\Models\BudgetStage;

use Modules\Purchase\Models\PurchaseCompromise;
use Modules\Purchase\Models\PurchaseCompromiseDetail;
use Modules\Purchase\Models\PurchaseStage;

use Module\Budget\Helpers\Helper;

use Module;

class PurchaseBudgetaryAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('purchase::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'purchase_supplier_id' => 'required|integer',
            'currency_id'          => 'required|integer',
            'file'                 => 'required|mimes:pdf',
            'base_budget_id'       => 'required',
            'description'          => 'required',
        ], [
            'file.required'                   => 'El archivo de acta de inicio es obligatorio.',
            'file.mimes'                      => 'El archivo de acta de inicio debe ser de tipo pdf.',
            'purchase_supplier_id.required'   => 'El campo proveedor es obligatorio.',
            'purchase_supplier_id.integer'    => 'El campo proveedor debe ser numerico.',
            'currency_id.required'            => 'El campo de tipo de moneda es obligatorio.',
            'currency_id.integer'             => 'El campo de tipo de moneda debe ser numerico.',
            'base_budget_id'                  => 'Debe seleccionar almenos un requerimiento.',
            'description'                     => 'El campo descripción es un campo obligatorio.',
        ]);

        $code_states = $this->generateCodeAvailable('purchase_states');
        if (!$code_states) {
            return response()->json(['error'=>'Error al intentar generar código para el estado del pre-compromiso'], 200);
        }

        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', $request->date)->orderBy('operation_date', 'DESC')->first();


        if (Module::has('Budget') && Module::isEnabled('Budget')) {
            $model_compromise = BudgetCompromise::class;
            $model_compromise_detail = BudgetCompromiseDetail::class;
            $model_state = BudgetStage::class;
        }else{
            $model_compromise = PurchaseCompromise::class;
            $model_compromise_detail = PurchaseCompromiseDetail::class;
            $model_state = PurchaseStage::class;
        }

        /////// Se guarda el archivo ///////
        $document = new UploadDocRepository();
        $name = $request['file']->getClientOriginalName();
        $docs = Document::where('file', ($name))->get()->count();

        $compromise = $model_compromise::create([
            'code' => $request->code,
            'description' => $request->description,
            'compromised_at' => $request->date,
            'document_status_id' => 4,   //id de document_status >> Elaborado(a) Faltan todas las firmas
        ]);

        $document->uploadDoc(
            $request['file'],
            'documents',
            PurchaseCompromise::class,
            $compromise->id,
            null
        );

        $model_compromise_detail::create([
            'description' => $request->description,
            'amount' => $request->subtotal,
            'tax_amount' => ($request->subtotal*100/$historyTax['percentage']),
            'tax_id' => $historyTax['tax_id'],
            'budget_compromise_id' => $compromise->id,
            'budget_account_id' => $request->budget_account_id,
            'budget_sub_specific_formulation_id' => $crequest->budget_sub_specific_formulation_id,
        ]);

        $state = $model_state::create([
            'code' => $code_states,
            'registered_at' => $request->date,
            'type' => 'PRE',
            'amount' => $request->subtotal,
            'budget_compromise_id' => $compromise->id,
        ]);
        
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show($id)
    {
        $purchase_quotation = PurchaseQuotation::with([
            'purchaseSupplier', 
            'currency', 
            'pivot_recordable.relatable.purchaseRequirement',
            'pivot_recordable.relatable.relatable.purchaseRequirementItem.warehouseProduct.measurementUnit',
            'relatable.purchaseRequirementItem.warehouseProduct.measurementUnit',
        ])->orderBy('id', 'ASC')->find($id);

        if (!$purchase_quotation) {
            return view('errors.404');
        }

        $currency = $purchase_quotation->currency;
        $supplier = $purchase_quotation->purchaseSupplier;

        $record_items = [];

        /**
         * [$has_budget determina si esta instalado el modulo Budget]
         * @var [boolean]
         */
        $has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));

        if ($has_budget) {
            $budget_items = template_choices(
                'Modules\Budget\Models\BudgetAccount',
                ['code', '-', 'denomination'],
                [],
                true
            );

            $specific_actions = template_choices(
                'Modules\Budget\Models\BudgetSpecificAction',
                ['code', '-', 'name'],
                [],
                true
            );

            return view('purchase::budgetary_availability.index', [
                'has_budget' => $has_budget,
                'record_items' => $purchase_quotation,
                'currency' => $currency,
                'supplier' => $supplier,
                'budget_items' => json_encode($budget_items),
                'specific_actions' => json_encode($specific_actions),
            ]);
        } else {
            return view('purchase::budgetary_availability.index', [
                'record_items' => $purchase_quotation,
                'currency' => $currency,
                'supplier' => $supplier,
                'budget_items' => json_encode([[
                    'id'=>'',
                    'text'=>'Seleccione...'
                ]]),
                'specific_actions' => json_encode([[
                    'id'=>'',
                    'text'=>'Seleccione...'
                ]]),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy()
    {
    }

    public function getBudgetAvailable($specific_action_id, $account_id)
    {
        return response()->json([
            'amount' => budget_available(
                                        FiscalYear::where('active', true)->first(), 
                                        $specific_action_id, 
                                        $account_id)
        ], 200);
    }

    /**
     * [generateCodeAvailable genera el código disponible]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return string|null [código que se asignara]
     */
    public function generateCodeAvailable($table)
    {
        $codeSetting = CodeSetting::where('table', $table)
                                    ->first();

        if (!$codeSetting) {
            $codeSetting = CodeSetting::where('table', $table)
                                    ->first();
        }

        if ($codeSetting) {
            $code  = generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                AccountingEntry::class,
                $codeSetting->field
            );
        } else {
            $code = null;
        }

        return $code;
    }
}
