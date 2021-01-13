<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\FiscalYear;
use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Purchase\Models\PurchaseBaseBudget;

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
            'base_budget_id'     => 'required',
        ], [
            'file_1.required'                 => 'El archivo de acta de inicio es obligatorio.',
            'file_1.mimes'                    => 'El archivo de acta de inicio debe ser de tipo pdf.',
            'file_2.required'                 => 'El archivo de invitación de las empresas es obligatorio.',
            'file_2.mimes'                    => 'El archivo de invitación de las empresas debe ser de tipo pdf.',
            'file_3.required'                 => 'El archivo de proforma / Cotización es obligatorio.',
            'file_3.mimes'                    => 'El archivo de proforma / Cotización debe ser de tipo pdf.',
            'purchase_supplier_id.required'   => 'El campo proveedor es obligatorio.',
            'purchase_supplier_id.integer'    => 'El campo proveedor debe ser numerico.',
            'currency_id.required'            => 'El campo de tipo de moneda es obligatorio.',
            'currency_id.integer'             => 'El campo de tipo de moneda debe ser numerico.',
            'base_budget_list'                => 'Debe seleccionar almenos un requerimiento.',
        ]);
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
}
