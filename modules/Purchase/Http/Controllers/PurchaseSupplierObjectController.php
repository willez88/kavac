<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseSupplierObject;
use Modules\Purchase\Models\PurchaseSupplier;

class PurchaseSupplierObjectController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseSupplierObject::all()], 200);
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
            'type' => ['required'],
            'name' => ['required', 'unique:purchase_supplier_objects,name'],
        ],
            [ 'type.required' => 'El campo tipo es obligatorio.']
        );

        $supplierObject = PurchaseSupplierObject::create([
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description ?? null
        ]);

        return response()->json(['record' => $supplierObject, 'message' => 'Success'], 200);
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
        /** @var object Datos del objeto de proveedores */
        $supplierObject = PurchaseSupplierObject::find($id);

        $this->validate($request, [
            'type' => ['required'],
            'name' => ['required', 'unique:purchase_supplier_objects,name,' . $supplierObject->id],
        ],
            [ 'type.required' => 'El campo tipo es obligatorio.']
        );

        $supplierObject->type = $request->type;
        $supplierObject->name = $request->name;
        $supplierObject->description = $request->description ?? null;
        $supplierObject->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /** @var object Datos del objeto de proveedores */
        $supplierObject = PurchaseSupplierObject::find($id);
        $supplierObject->delete();
        return response()->json(['record' => $supplierObject, 'message' => 'Success'], 200);
    }

    /**
     * [getPurchaseSupplierObject retorna el obeto del proveedor]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id ID del proveedor
     * @return JsonResponse
     */
    public function getPurchaseSupplierObject($id)
    {
        return response()->json(PurchaseSupplier::find($id)->PurchaseSupplierObject);
    }
}
