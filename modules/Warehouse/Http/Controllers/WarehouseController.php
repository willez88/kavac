<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\Warehouse;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;

use App\Models\Institution;
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
        return response()->json(['records' => Warehouse::with('country','estate','city')->with(['pivot' =>
                function($query){
                    $query->with('institution');
                }])->get()],200);
        
        //return response()->json(['records' => Warehouse::with('pivot','country','estate','city')->get()], 200);
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
            'city_id' => 'required',
            
        ]);

        $warehouse = Warehouse::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'country_id' => $request->input('country_id'),
            'estate_id' => $request->input('estate_id'),
            'city_id' => $request->input('city_id'),
            'main' => !empty($request->main)?$request->input('main'):false,
            'active' => !empty($request->active)?$request->input('active'):false,
        ]);
        if ( empty($request->institution_id)){
            $institution = Institution::where('active',true)->where('default',true)->first();
        }
        $institution_id =  empty($request->institution_id)?$institution->id:$request->institution_id;

        $warehouse_institution = WarehouseInstitutionWarehouse::create([
            'institution_id' => $institution_id,
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
            'city_id' => 'required',
        ]);
 
        $warehouse->name = $request->input('name');
        $warehouse->address = $request->input('address');
        $warehouse->country_id = $request->input('country_id');
        $warehouse->estate_id = $request->input('estate_id');
        $warehouse->city_id = $request->input('city_id');

        $warehouse->main = !empty($request->main)?$request->input('main'):false;
        $warehouse->active = !empty($request->active)?$request->input('active'):false;
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

    public function manage($id){

        $warehouse_inst = WarehouseInstitutionWarehouse::where('warehouse_id',$id)->first();
        $warehouse_inst->manage = !$warehouse_inst->manage;
        $warehouse_inst->save();

        return response()->json(['records' => Warehouse::with('country','estate','city')->with(['pivot' =>
                    function($query){
                        $query->with('institution');
                    }])->get(),'manage' => $warehouse_inst->manage],200);
    }

    /**
     * Construye un arreglo de elementos para usar en plantillas blade
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $institution   Institucion que gestiona los almacenes a ser buscados
     * @return array   Arreglo con las opciones a mostrar
     */

    public function getWarehouses($institution = null){
        /*
         *  Si no hay datos sobre la institución de gestión se retornan los almacenes de la institucion por defecto y activa según la configuración del sistema
         */
        if (is_null($institution)){
            $institution = Institution::where('active',true)->where('default',true)->first();
            $institution = $institution->id;
        }
        $records = WarehouseInstitutionWarehouse::where('institution_id', $institution)->with('warehouse')->get();

        /** Inicia la opción vacia por defecto */
        $options = (count($records) >= 1) ? [['id' => '', 'text' => 'Seleccione...']] : [];

        foreach ($records as $rec) {            
            $text = $rec->warehouse->name;
            array_push($options, ['id' => $rec->id, 'text' => $text]);
        }
        return $options;
    }
}
