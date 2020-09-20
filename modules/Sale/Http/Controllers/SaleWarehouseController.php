<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleWarehouse;

class SaleWarehouseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => SaleWarehouse::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:200'],
            'institution_id' => ['required', 'max:200'],
            'address' => ['required', 'max:900'],
            'parish_id' => ['required', 'max:300'],
            'main' => ['required'],
            'active' => ['required'],
        ]);
        $SaleWarehouse = SaleWarehouse::create(['name' => $request->name,'address' => $request->address,'institution_id' => $request->institution_id,'parish_id' => $request->parish_id,'main' => $request->main,'active' => $request->active]);
        return response()->json(['record' => $SaleWarehouse, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        //return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        //return view('sale::edit');
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
     * @return JsonResponse
     */
    public function destroy()
    {
        $SaleWarehouse = SaleWarehouse::find($id);
        $SaleWarehouse->delete();
        return response()->json(['record' => $SaleWarehouse, 'message' => 'Success'], 200);
    }

    public function getSaleWarehouseMethod()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleWarehouse', 'name', '', true));
    }
}
