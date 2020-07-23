<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleWarehouse;

class SaleWarehouseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        return response()->json(['records' => SaleWarehouse::all()], 200);
        /*
        if (!is_null($institution)) {
            return response()->json(['records' => SaleWarehouse::where('institution_id', $institution)
                ->with(
                    ['sale_warehouses' =>
                    function ($query) {
                        $query->with(['parish' => function ($query) {
                            $query->with(['municipality' => function ($query) {
                                $query->with(['estate' => function ($query) {
                                    $query->with('country');
                                }]);
                            }]);
                        }]);
                    },'institution']
                )->get()], 200);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
            $institution = $institution->id;
            return response()->json(['records' => SaleWarehouse::where('institution_id', $institution)
                ->with(
                    ['sale_warehouses' =>
                    function ($query) {
                        $query->with(['parish' => function ($query) {
                            $query->with(['municipality' => function ($query) {
                                $query->with(['estate' => function ($query) {
                                    $query->with('country');
                                }]);
                            }]);
                        }]);
                    },'institution']
                )->get()], 200);
        }
        */
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
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:200'],
            'institution_id' => ['required', 'max:200'],
            'address' => ['required', 'max:900'],
            'parish_id' => ['required'],
        ]);
        //Define almacén principal
        if ($request->input('main') == true) {
            $main = SaleWarehouse::where('main', '=', true)->update(array('main' => false));
        }
        //Guarda datos de almacen.
        $SaleWarehouse = SaleWarehouse::create(['name' => $request->name,'address' => $request->address,'institution_id' => $request->institution_id,'parish_id' => $request->parish_id,'main' => !empty($request->input('main')) ? $request->input('main'): false,'active' => !empty($request->input('active')) ? $request->input('active') : false]);

        return response()->json(['record' => $SaleWarehouse, 'message' => 'Success'], 200);
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $SaleWarehouse = SaleWarehouse::find($id);
        $SaleWarehouse->delete();
        return response()->json(['record' => $SaleWarehouse, 'message' => 'Success'], 200);
    }

   /**
   * Obtiene los alamacenes registrados
   *
   * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
   * @return \Illuminate\Http\JsonResponse    Json con los datos de los alamacenes registrados
   */
    public function getSaleWarehouseMethod()
    {
        //return response()->json(template_choices('Modules\Sale\Models\SaleWarehouse', 'name', '', true));
    }
}