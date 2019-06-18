<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseSupplierSpecialty;

class PurchaseSupplierSpecialtyController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return response()->json(['records' => PurchaseSupplierSpecialty::all()], 200);
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
            'name' => 'required|unique:purchase_supplier_specialties,name',
        ]);

        $supplierSpecialty = PurchaseSupplierSpecialty::create([
            'name' => $request->name,
            'description' => $request->description ?? null
        ]);

        return response()->json(['record' => $supplierSpecialty, 'message' => 'Success'], 200);
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
        /** @var object Datos de la especialidad de proveedores */
        $supplierSpecialty = PurchaseSupplierSpecialty::find($id);
        
        $this->validate($request, [
            'name' => 'required|unique:purchase_supplier_specialties,name,' . $supplierSpecialty->id,
        ]);
 
        $supplierSpecialty->name = $request->name;
        $supplierSpecialty->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\View\View
     */
    public function destroy()
    {
        /** @var object Datos de la especialidad de proveedores */
        $supplierSpecialty = PurchaseSupplierSpecialty::find($id);
        $supplierSpecialty->delete();
        return response()->json(['record' => $supplierSpecialty, 'message' => 'Success'], 200);
    }
}
