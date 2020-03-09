<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseBaseBudget;

class PurchaseBudgetaryAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('purchase::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
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
                    }
                    if ($r['relatable_type'] == PurchaseBaseBudget::class) {
                        $data['base_price'] = $r['unit_price'];
                    }
                }
                array_push($record_items, $data);
            }
        }
        return view('purchase::budgetary_availability.index', [
            'record_items' => json_encode($record_items),
            'currency' => $currency,
            'supplier' => $supplier,
        ]);
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
}
