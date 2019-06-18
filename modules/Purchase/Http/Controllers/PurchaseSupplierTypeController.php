<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseSupplierType;

class PurchaseSupplierTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return response()->json(['records' => PurchaseSupplierType::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:purchase_supplier_types,name',
        ]);

        $supplierType = PurchaseSupplierType::create([
            'name' => $request->name
        ]);

        return response()->json(['record' => $supplierType, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\View\View
     */
    public function destroy()
    {
    }
}
