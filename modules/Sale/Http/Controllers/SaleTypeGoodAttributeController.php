<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\SaleTypeGoodAttribute;

/**
 * Eliminar
 */
class SaleTypeGoodAttributeController extends Controller
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
        // $this->middleware('permission:sale.setting.attribute');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => []], 200);
    }

    public function product($id)
    {
        return response()->json(['records' => SaleTypeGoodAttribute::where('sale_type_good_id', '=', $id)->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'sale_type_good_id' => ['required'],
        ]);

        $id = $request->input('sale_type_good_id');

        $attribute = SaleTypeGoodAttribute::create([
            'name' => $request->input('name'),
            'sale_type_good_id' => $request->input('sale_type_good_id'),
        ]);

        return response()->json(['records' => SaleTypeGoodAttribute::where('sale_type_good_id', '=', $id)->get()], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, SaleTypeGoodAttribute $attribute)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'sale_type_good_id' => ['required'],
        ]);

        $attribute->name = $request->input('name');
        $attribute->sale_type_good_id = $request->input('sale_type_good_id');
        $attribute->save();

        $id = $attribute->sale_type_good_id;

        return response()->json(['records' => SaleTypeGoodAttribute::where('sale_type_good_id', '=', $id)->get()], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(SaleTypeGoodAttribute $attribute)
    {
        $attribute->delete();
        return response()->json(['record' => $attribute, 'message' => 'Success'], 200);
    }
}
