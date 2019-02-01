<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\Warehouse;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;

use App\Models\Setting;


/**
 * @class WarehouseController
 * @brief Controlador de los Almacenes
 * 
 * Clase que gestiona los almacenes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.setting.warehouse');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //WarehouseInstitutionWarehouse::with('institution','warehouse')->get()
        return response()->json(['records' => Warehouse::with('pivot','country','estate','city')->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'country_id' => 'required',
            'estate_id' => 'required',
            
        ]);

        $warehouse = Warehouse::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'country_id' => $request->input('country_id'),
            'estate_id' => $request->input('estate_id'),
            'city_id' => 1,
            //'main' => $request->input('main'),
        ]);
        $warehouse_institution = WarehouseInstitutionWarehouse::create([
            'institution_id' => 1,
            'warehouse_id' => $warehouse->id,
        ]);

        return response()->json(['record' => $warehouse, 'message' => 'Success'], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,Warehouse $warehouse)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'country_id' => 'required',
            'estate_id' => 'required',
            //'city_id' => 'required',
        ]);
 
        $warehouse->name = $request->input('name');
        $warehouse->address = $request->input('address');
        $warehouse->country_id = $request->input('country_id');
        $warehouse->estate_id = $request->input('estate_id');
        $warehouse->city_id = 1;
        $warehouse->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseInstitutionWarehouse $warehouse)
    {
        $warehouse->delete();
        return response()->json(['record' => $warehouse, 'message' => 'Success'], 200);
    }

    public function vueList(){
        return template_choices('Modules\Warehouse\Models\Warehouse','name','',true);
    }

    public function checkInst(){
        return response()->json(['record' => Setting::first()], 200);
    }

    public function manage(){
        return response()->json(['records' => WarehouseInstitutionWarehouse::all()] , 200);
    }
}
