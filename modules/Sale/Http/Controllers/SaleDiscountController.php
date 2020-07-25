<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SaleDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => SaleDiscount::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
    //    return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:200'],
            'percent' => ['required', 'max:100']

        ]);
        $SaleDiscount = SaleDiscount::create(['name' => $request->name,'description' => $request->description, 'percent' => $request->percent]);
        return response()->json(['record' => $SaleDiscount, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
     //   return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
     //   return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request $id)
    {
        $SaleDiscount = SaleDiscount::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:200'],
            'percent' => ['required', 'max:100']
        ]);
        $SaleDiscount->name  = $request->name;
        $SaleDiscount->description = $request->description;
        $SaleDiscount->percent  = $request->percent;
        $SaleDiscount->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $SaleDiscount = SaleDiscount::find($id);
        $SaleDiscount->delete();
        return response()->json(['record' => $SaleDiscount, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los descuento registrados
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los descuentos
     */
    public function getSaleDiscount()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleDiscount', 'name', '', true));
    }
}
