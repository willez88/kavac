<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleOrderManagement;

class SaleOrderManagementController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     */

    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador *//*
        $this->middleware('permission:sale.payment.method.list', ['only' => 'index']);
        $this->middleware('permission:sale.payment.method.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.payment.method.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.payment.method.delete', ['only' => 'destroy']);*/
    }

    /**
     * Muestra todos los registros de gestión de pedidos
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => SaleOrderManagement::all()], 200);
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
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'cedule' => ['required', 'max:20'],
            'address' => ['required', 'max:200'],
            'contact_number' => ['required', 'max:50']
        ]);
        $SaleOrderManagement = SaleOrderManagement::create([
            'name' => $request->name, 'cedule' => $request->name, 'address' => $request->name, 'contact_number' => $request->description
        ]);
        return response()->json(['record' => $SaleOrderManagement, 'message' => 'Success'], 200);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $SaleOrderManagement = SaleOrderManagement::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'cedule' => ['required', 'max:20'],
            'address' => ['required', 'max:200'],
            'contact_number' => ['required', 'max:50']
        ]);
        $SaleOrderManagement->name  = $request->name;
        $SaleOrderManagement->cedule = $request->cedule;
        $SaleOrderManagement->address = $request->address;
        $SaleOrderManagement->contact_number = $request->contact_number;
        $SaleOrderManagement->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $SaleOrderManagement = SaleOrderManagement::find($id);
        $SaleOrderManagement->delete();
        return response()->json(['record' => $SaleOrderManagement, 'message' => 'Success'], 200);
    }
    /**
     * Obtiene los tipos de  metodos de pago
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return JsonResponse    Json con los datos de los tipos de pago
     */
    public function getSaleOrderManagementMethod()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleOrderManagement', 'name', '', true));
    }
}
