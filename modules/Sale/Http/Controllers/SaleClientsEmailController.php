<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\SaleClientsEmail;

/**
 * Eliminar
 */
class SaleClientsEmailController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        // $this->middleware('permission:sale.setting.email');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => []], 200);
    }

    public function client($id)
    {
        return response()->json(['records' => SaleClientsEmail::where('sale_client_id', '=', $id)->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'max:100'],
            'sale_client_id' => ['required'],
        ]);

        $id = $request->input('sale_client_id');

        $email = SaleClientsEmail::create([
            'email' => $request->input('email'),
            'sale_client_id' => $request->input('sale_client_id'),
        ]);

        return response()->json(['records' => SaleClientsEmail::where('sale_client_id', '=', $id)->get()], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, SaleClientsEmail $email)
    {
        $this->validate($request, [
            'email' => ['required', 'max:100'],
            'sale_client_id' => ['required'],
        ]);

        $email->email = $request->input('email');
        $email->sale_client_id = $request->input('sale_client_id');
        $email->save();

        $id = $email->sale_client_id;

        return response()->json(['records' => SaleClientsEmail::where('sale_client_id', '=', $id)->get()], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(SaleClientsEmail $email)
    {
        $email->delete();
        return response()->json(['record' => $email, 'message' => 'Success'], 200);
    }
}
