<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SalePaymentMethod;

class ClientsPaymentController extends Controller
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
     * Muestra todos los registros de tipos de personal
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return Renderable
     */
    public function index()
    {
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
     * Valida y registra un nuevo metodo de pago
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:200']
        ]);
        $salePaymentMethod = SalePaymentMethod::create([
            'name' => $request->name,'description' => $request->description
        ]);
        return response()->json(['record' => $salePaymentMethod, 'message' => 'Success'], 200);
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
     * Actualiza la información del metodo de pago
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del datos a actualizar
     * @return JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $salePaymentMethod = SalePaymentMethod::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200']
        ]);
        $salePaymentMethod->name  = $request->name;
        $salePaymentMethod->description = $request->description;
        $salePaymentMethod->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el metodo de pago
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del metodo de pago a eliminar
     * @return JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $salePaymentMethod = SalePaymentMethod::find($id);
        $salePaymentMethod->delete();
        return response()->json(['record' => $salePaymentMethod, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de pago registrados
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return JsonResponse    Json con los datos de los tipos de pago
     */
    public function getSalePaymentMethod()
    {
        return response()->json(template_choices('Modules\Sale\Models\SalePaymentMethod', 'name', '', true));
    }
}
