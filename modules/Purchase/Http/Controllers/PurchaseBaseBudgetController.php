<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Jobs\PurchaseManageBaseBudget;


use Modules\Purchase\Models\PurchaseBaseBudget;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;
use Modules\Purchase\Models\HistoryTax;

class PurchaseBaseBudgetController extends Controller
{
    use ValidatesRequests;

    protected $currencies;

    public function __construct()
    {
        $this->currencies = template_choices('App\Models\Currency', 'name', [], true);
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'records' => PurchaseBaseBudget::with(
                'currency',
                'purchaseRequirement.contratingDepartment',
                'purchaseRequirement.userDepartment',
                'relatable.purchaseRequirementItem.purchaseRequirement'
            )->orderBy('id', 'ASC')->get(),
            'message'=>'success'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirementItems.warehouseProduct.measurementUnit'
        )->where('requirement_status', 'WAIT')->orderBy('code', 'ASC')->get();
        return view('purchase::requirements.base_budget', [
                    'requirements' => $requirements,
                    'tax'          => json_encode($historyTax),
                    'currencies'   => json_encode($this->currencies),
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
            'list'        => 'required|array',
            'currency_id' => 'required|int',
            'tax_id'      => 'required|int',
        ], [
            'list.required'        => 'No es permitido guardar presupuesto base vacios.',
            'list.array'           => 'Los registros deben estar en una lista.',
            'currency_id.required' => 'El campo moneda es obligatorio.',
            'currency_id.int'      => 'El campo moneda debe ser numerico.',
            'tax_id.required'      => 'El campo del IVA es obligatorio, verifique que este registrado en la
            configuración base del sistema',
            'tax_id.int'           => 'El campo del IVA debe ser numerico.',
        ]);
        $data = $request->all();
        $data['action'] = 'create';
        PurchaseManageBaseBudget::dispatch($data);
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Show the specified resource.
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(['records' => PurchaseBaseBudget::with(
            'currency',
            'purchaseRequirement.contratingDepartment',
            'purchaseRequirement.userDepartment',
            'relatable.purchaseRequirementItem.purchaseRequirement',
            'relatable.purchaseRequirementItem.warehouseProduct.measurementUnit',
        )->find($id)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit($id)
    {
        $baseBudget = PurchaseBaseBudget::with(
            'purchaseRequirement.contratingDepartment',
            'purchaseRequirement.userDepartment',
            'purchaseRequirement.purchaseRequirementItems.warehouseProduct.measurementUnit',
            'relatable'
        )->find($id);

        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        // $requirements = PurchaseRequirement::with(
        //     'contratingDepartment',
        //     'userDepartment',
        //     'purchaseRequirementItems'
        // )->where('requirement_status', 'WAIT')->orderBy('code', 'ASC')->get();

        return view('purchase::requirements.base_budget', [
                    'requirements' => json_encode([0 => $baseBudget['purchaseRequirement']]),
                    'tax'          => json_encode($historyTax),
                    'currencies'   => json_encode($this->currencies),
                    'baseBudget'   => $baseBudget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'list'        => 'required|array',
            'currency_id' => 'required|int',
            'tax_id' => 'required|int',
        ], [
            'list.required'        => 'No es permitido guardar presupuesto base vacios.',
            'list.array'           => 'Los registros deben estar en una lista.',
            'currency_id.required' => 'El campo moneda es obligatorio.',
            'currency_id.int'      => 'El campo moneda debe ser numerico.',
            'tax_id.required'      => 'El campo del IVA es obligatorio, verifique que este registrado en la
            configuración base del sistema',
            'tax_id.int'           => 'El campo del IVA debe ser numerico.',
        ]);

        $data = $request->all();
        $data['id_edit'] = $id;
        $data['action'] = 'update';
        PurchaseManageBaseBudget::dispatch($data);
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $record = PurchaseBaseBudget::find($id);
        if ($record) {
            foreach (PurchaseRequirement::where('purchase_base_budget_id', $id)->orderBy('id', 'ASC')->get() as $r) {
                // $r->purchase_base_budget_id = null;
                // $r->requirement_status = 'WAIT';
                $r->delete();
            }
            foreach (PurchasePivotModelsToRequirementItem::where('relatable_id', $id)
                    ->orderBy('id', 'ASC')->get() as $r) {
                $r->delete();
            }
            $record->delete();
        } else {
            return response()->json(['message'=>'El registro ya fue eliminado.'], 200);
        }
        return response()->json(['message'=>'success'], 200);
    }
}
