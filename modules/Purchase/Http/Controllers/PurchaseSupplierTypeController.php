<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseSupplierType;

class PurchaseSupplierTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseSupplierType::all()], 200);
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
            'name' => ['required', 'unique:purchase_supplier_types,name'],
        ]);

        $supplierType = PurchaseSupplierType::create([
            'name' => $request->name
        ]);

        return response()->json(['record' => $supplierType, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('purchase::show');
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var object Datos del tipo de proveedores */
        $supplierType = PurchaseSupplierType::find($id);

        $this->validate($request, [
            'name' => ['required', 'unique:purchase_supplier_types,name,' . $supplierType->id],
        ]);

        $supplierType->name = $request->name;
        $supplierType->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /** @var object Datos del tipo de proveedores */
        $supplierType = PurchaseSupplierType::find($id);
        $supplierType->delete();
        return response()->json(['record' => $supplierType, 'message' => 'Success'], 200);
    }
}
