<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleWarehouseInstitutionWarehouse;
use Modules\Sale\Models\SaleWarehouse;

class SaleWarehouseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => SaleWarehouse::all()], 200);
        
        if (!is_null($institution)) {
            return response()->json(['records' => SaleWarehouseInstitutionWarehouse::where('institution_id', $institution)
                ->with(
                    ['sale_warehouse' =>
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
            return response()->json(['records' => SaleWarehouseInstitutionWarehouse::where('institution_id', $institution)
                ->with(
                    ['sale_warehouse' =>
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
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:200'],
            'address' => ['required', 'max:900'],
            'parish_id' => ['required'],
        ]);
        //Define almacén principal
        if ($request->input('main') == true) {
            $main = SaleWarehouse::where('main', '=', true)->update(['main' => false]);
        }
        //Guarda datos de almacen.
        $SaleWarehouse = SaleWarehouse::create([

            'name' => $request->name,
            'address' => $request->address,
            'parish_id' => $request->parish_id,
            'active' => !empty($request->input('active')) ? $request->input('active') : false
        ]);

        if (empty($request->institution_id)) {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        $institution_id = empty($request->institution_id)?$institution->id:$request->institution_id;

        $sale_warehouse_institution = SaleWarehouseInstitutionWarehouse::create([
            'institution_id' => $institution_id,
            'sale_warehouse_id'   => $SaleWarehouse->id,
            'main'           => !empty($request->main)?$request->input('main'):false,
        ]);

        return response()->json(['record' => $SaleWarehouse, 'message' => 'Success'], 200);
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {   
        $sale_warehouse_institution = SaleWarehouseInstitutionWarehouse::find($id);
        $SaleWarehouse = SaleWarehouse::find($sale_warehouse_institution->sale_warehouse_id);
        $sale_warehouse_institution->delete();
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
        return response()->json(template_choices('Modules\Sale\Models\SaleWarehouse', 'name', '', true));
    }
}
