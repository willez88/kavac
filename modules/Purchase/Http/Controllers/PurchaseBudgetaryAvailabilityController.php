<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\purchaseRequirement;

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
            'purchaseRequirement.purchaseRequirementItems',
            'purchaseRequirement.purchaseBaseBudget',
        )->find($id);

        if (!$purchase_order || !$purchase_order->active) {
            return view('errors.404');
        }

        $requirements = purchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirement.purchaseRequirementItems',
            'purchaseRequirement.purchaseBaseBudget.currency',
            'purchaseRequirement.purchaseOrder.currency',
            'purchaseRequirement.purchaseOrder.purchaseSupplier',
        )->where('purchase_order', $id)->orderBy('code', 'ASC')->get();

        return view('purchase::budgetary_availability.index', [
            'record' => $requirements
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
