<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseSupplierBranch;

class PurchaseSupplierBranchController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseSupplierBranch::all()], 200);
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:purchase_supplier_branches,name'],
        ]);

        $supplierBranch = PurchaseSupplierBranch::create([
            'name' => $request->name,
            'description' => $request->description ?? null
        ]);

        return response()->json(['record' => $supplierBranch, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show($id)
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit($id)
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        /** @var object Datos de la rama de proveedores */
        $supplierBranch = PurchaseSupplierBranch::find($request->id);

        $this->validate($request, [
            'name' => ['required', 'unique:purchase_supplier_branches,name,' . $supplierBranch->id],
        ]);

        $supplierBranch->name = $request->name;
        $supplierBranch->description = $request->description;
        $supplierBranch->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        /** @var object Datos de la rama de proveedores */
        $supplierBranch = PurchaseSupplierBranch::find($id);
        $supplierBranch->delete();
        return response()->json(['record' => $supplierBranch, 'message' => 'Success'], 200);
    }
}
