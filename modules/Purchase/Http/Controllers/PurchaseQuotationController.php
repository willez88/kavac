<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\purchaseBaseBudget;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;

use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;
use Modules\Purchase\Models\Currency;

use Modules\Purchase\Models\PurchaseSupplier;

use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Repositories\UploadDocRepository;

use App\Models\ExchangeRate;

class PurchaseQuotationController extends Controller
{
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
        
        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirementItems.measurementUnit',
            'purchaseBaseBudget.currency'
        )->where('requirement_status', 'PROCESSED')
        ->orderBy('id', 'ASC')->get();

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
}
