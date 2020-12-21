<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Modules\Sale\Models\SaleWarehouseInventoryRule;
use Modules\Sale\Models\SaleWarehouse;
use App\Models\Institution;
use Carbon\Carbon;

class SaleReportController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sale::index');
    }

    public function inventoryProducts()
    {
        return view('sale::reports.sale-report-products');
    }

    public function vueList(Request $request)
    {
        if ($request->current == "inventory-products") {
            $fields = SaleWarehouseInventoryProduct::with(
                [
                    'currency',
                    'saleSettingProduct',
                    'saleWarehouseInventoryRule',
                    'saleWarehouseProductValues',
                    'saleWarehouseInstitutionWarehouse' => function ($query) {
                        $query->with('sale_warehouse');
                    },
                ]
            )->orderBy('sale_setting_product_id');
            if ($request->sale_setting_product_id > 0) {
                $fields = $fields->where(
                    'sale_setting_product_id',
                    $request->sale_setting_product_id
                );
            }
            if ($request->institution_id > 0) {
                $institutionsSaleWarehouses = DB::table('sale_warehouse_institution_warehouses')
                    ->where('institution_id', $request->institution_id)
                    ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'sale_warehouse_institution_warehouse_id',
                    $institutionsSaleWarehouses
                );
            }
            if ($request->sale_warehouse_id > 0) {
                $institutionsSaleWarehouses = DB::table('sale_warehouse_institution_warehouses')
                        ->where('sale_warehouse_id', $request->sale_warehouse_id)
                        ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'sale_warehouse_institution_warehouse_id',
                    $institutionsSaleWarehouses
                );
            }
            if ($request->type_search == "date") {
                if (!is_null($request->start_date)) {
                    if (!is_null($request->end_date)) {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                $request->end_date
                            ]
                        );
                    } else {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                now()
                            ]
                        );
                    }
                }
            }
            if ($request->type_search == "mes") {
                if (!is_null($request->mes_id)) {
                    if (!is_null($request->year)) {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        )->whereYear('created_at', $request->year);
                    } else {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        );
                    }
                }
            }
        }

        return response()->json(['records' => $fields->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
