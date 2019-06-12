<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
     * Muestra un listado de los Almacenes Registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  $institution  Identificador único de la institución que gestiona el almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function index($institution = null)
    {
        if(!is_null($institution)){
            return response()->json(['records' => WarehouseInstitutionWarehouse::where('institution_id', $institution)
                ->with(['warehouse' => 
                    function($query){
                        $query->with('country','estate','city');
                    },'institution']
                )->get()], 200);
        }
        else{
            $institution = Institution::where('active',true)->where('default',true)->first();
            $institution = $institution->id;
            return response()->json(['records' => WarehouseInstitutionWarehouse::where('institution_id', $institution)
                ->with(['warehouse' => 
                    function($query){
                        $query->with('country','estate','city');
                    },'institution']
                )->get()], 200);
        }
    }

    /**
     * Valida y Registra un nuevo Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
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
                'active' => !empty($request->active)?$request->input('active'):false,
            ]);
            if ( empty($request->institution_id)){
                $institution = Institution::where('active',true)->where('default',true)->first();
            }
            $institution_id =  empty($request->institution_id)?$institution->id:$request->institution_id;

            $warehouse_institution = WarehouseInstitutionWarehouse::create([
                'institution_id' => $institution_id,
                'warehouse_id' => $warehouse->id,
                'main' => !empty($request->main)?$request->input('main'):false,
            ]);
            

            $setting = Setting::where('active', true)->first();
            
            if( is_null($setting) || ($setting->multi_warehouse == false) ){
                $inst_wares = WarehouseInstitutionWarehouse::where('institution_id', $institution_id)->with('warehouse')->get();

                foreach ($inst_wares as $inst_ware) {

                    if($inst_ware->warehouse_id != $warehouse->id){
                        
                        $record = Warehouse::find($inst_ware->warehouse_id);
                        $record->active = ($warehouse->active == true)?false:$record->active;
                        $record->save();
                        if(!empty($request->main) && ($inst_ware->main == $request->main)){
                            $inst_ware->main = !$inst_ware->main;
                            $inst_ware->save();
                        }
                    }
                }                
            }

        return response()->json(['record' => $warehouse, 'message' => 'Success'], 200);
    }


    /**
     * Actualiza la información de los Almacenes Registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\Warehouse  $warehouse (Datos del almacén)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, Warehouse $warehouse)
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

        $warehouse->active = !empty($request->active)?$request->input('active'):false;
        $warehouse->save();

        if ( empty($request->institution_id)){
                $institution = Institution::where('active',true)->where('default',true)->first();
            }
            $institution_id =  empty($request->institution_id)?$institution->id:$request->institution_id;

            $warehouse_institution = WarehouseInstitutionWarehouse::where('institution_id', $institution_id)
                                    ->where('warehouse_id', $warehouse->id)->first();

            $setting = Setting::where('active', true)->first();
            
            if( is_null($setting) || ($setting->multi_warehouse == false) ){
                $inst_wares = WarehouseInstitutionWarehouse::where('institution_id', $institution_id)->with('warehouse')->get();

                foreach ($inst_wares as $inst_ware) {

                    if($inst_ware->warehouse_id != $warehouse->id){
                        
                        $record = Warehouse::find($inst_ware->warehouse_id);
                        $record->active = ($warehouse->active == true)?false:$record->active;
                        $record->save();
                        if(!empty($request->main) && ($inst_ware->main == $request->main)){
                            $inst_ware->main = !$inst_ware->main;
                            $inst_ware->save();
                        }
                    }
                }                
            }
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina un Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del registro
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $inst_ware = WarehouseInstitutionWarehouse::find($id);
        $warehouse = Warehouse::find($inst_ware->warehouse_id);
        $inst_ware->delete();
        $warehouse->delete();
        return response()->json(['record' => $warehouse, 'message' => 'Success'], 200);

    }

    /**
     * Devuelve 
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Warehouse\Models\Warehouse $warehouse (Datos del almacén)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function vueList(){
        return template_choices('Modules\Warehouse\Models\Warehouse','name','',true);
    }


    public function manage($id){

        $warehouse_inst = WarehouseInstitutionWarehouse::where('warehouse_id',$id)->first();
        $warehouse_inst->manage = !$warehouse_inst->manage;
        $warehouse_inst->save();

        return response()->json(['records' => WarehouseInstitutionWarehouse::where('institution_id', $warehouse_inst->institution_id)
                ->with(['warehouse' => 
                    function($query){
                        $query->with('country','estate','city');
                    },'institution']
                )->get(),'manage' => $warehouse_inst->manage],200);
    }

    /**
     * Construye un arreglo de elementos para usar en plantillas blade
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
