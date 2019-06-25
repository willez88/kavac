<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Purchase\Models\PurchaseSupplier;

class PurchaseSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('purchase::suppliers.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('purchase::suppliers.create-edit-form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
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

    /**
     * Obtiene listado de registros
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function vueList()
    {
        return response()->json(['records' => PurchaseSupplier::all()], 200);
    }
}
