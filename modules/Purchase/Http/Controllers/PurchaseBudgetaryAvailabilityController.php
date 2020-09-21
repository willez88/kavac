<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseBaseBudget;

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
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show($id)
    {
        $purchase_order = PurchaseOrder::with(
            'currency',
            'purchaseSupplier',
            'purchaseRequirement.purchaseRequirementItems.pivotPurchase',
        )->find($id);

        if (!$purchase_order) {
            return view('errors.404');
        }

        $currency = $purchase_order->currency;
        $supplier = $purchase_order->purchaseSupplier;

        $record_items = [];

        // Se recorren los requerimientos
        $requirements = $purchase_order->purchaseRequirement;
        foreach ($requirements as $requirement) {
            $data = [];
            $data['code'] = $requirement['code'];

            // Se recorren los items del requerimiento
            $items = $requirement['purchaseRequirementItems'];
            foreach ($items as $item) {
                $data['name']        = $item['name'];
                $data['description'] = $item['description'];
                $data['qty']         = $item['quantity'].' '.$item['measurementUnit']['acronym'];

                // se recorre la relacion del requerimiento para obtener los precios
                foreach ($item['pivotPurchase'] as $r) {
                    if ($r['relatable_type'] == PurchaseOrder::class) {
                        $data['suppliers_price'] = $r['unit_price'];
                        $data['suppliers_qty_price'] = $r['unit_price'];
                    }
                    if ($r['relatable_type'] == PurchaseBaseBudget::class) {
                        $data['base_price'] = $r['unit_price'];
                        $data['base_qty_price'] = $r['unit_price'];
                    }
                }
                array_push($record_items, $data);
            }
        }

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
            return view('purchase::budgetary_availability.index', [
                'record_items' => json_encode($record_items),
                'currency' => $currency,
                'supplier' => $supplier,
                'budget_items' => json_encode($budget_items),
            ]);
        } else {
            return view('purchase::budgetary_availability.index', [
                'record_items' => json_encode($record_items),
                'currency' => $currency,
                'supplier' => $supplier,
                'budget_items' => json_encode([[
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
}
