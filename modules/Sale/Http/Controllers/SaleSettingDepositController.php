<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleSettingDeposit;

class SaleSettingDepositController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */

    public function __construct()
    {
        /** Establece permisos de acceso para cada forma del controlador *//*
        $this->middleware('permission:sale.setting.deposit.list', ['only' => 'index']);
        $this->middleware('permission:sale.setting.deposit.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.setting.deposit.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.setting.deposit.delete', ['only' => 'destroy']);*/
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */

    /**
     * Muestra todos los registros de las formas de pago
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
         return response()->json(['records' => SaleSettingDeposit::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //return view('sale::create');
    }

    /**
     * Valida y registra un nuevo tipo de forma de pago
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required'],
            'deposit_attributes' => ['required']
        ]);
        $saleSettingDeposit = SaleSettingDeposit::create(['name' => $request->name, 'description' => $request->description, 'deposit_attributes' => $request->deposit_attributes]);
        return response()->json(['record' => $saleSettingDeposit, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //return view('sale::edit');
    }

    /**
     * Actualiza la información de las formas de pago
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del datos a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $saleSettingDeposit = SaleSettingDeposit::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required'],
            'deposit_attributes' => ['required'],
        ]);
        $saleSettingDeposit->name  = $request->name;
        $saleSettingDeposit->description  = $request->description;
        $saleSettingDeposit->deposit_attributes  = $request->deposit_attributes;
        $saleSettingDeposit->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la forma de pago
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  integer $id                      Identificador del producto a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $saleSettingDeposit = SaleSettingDeposit::find($id);
        $saleSettingDeposit->delete();
        return response()->json(['record' => $saleSettingDeposit, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las formas de pago registradas
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los tipos de forma de pago
     */
    public function getSaleSettingDeposit()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleSettingDeposit', 'name',  '', '', true));
    }
}
