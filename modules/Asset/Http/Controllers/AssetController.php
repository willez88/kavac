<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Asset\Models\Asset;

use Modules\Asset\Models\AssetInventary;

/**
 * @class AssetController
 * @brief Controlador de Bienes Institucionales
 * 
 * Clase que gestiona los Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.list', ['only' => 'index']);
        $this->middleware('permission:asset.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $assets = Asset::all();
        return view('asset::registers.list', compact('assets'));
    }

    /**
     * Muestra el formulario para registrar un nuevo Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('asset::registers.create');
    }

    /**
     * Valida y Registra un nuevo Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [


            'type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'specific_category_id' => 'required',
            //'institution_id' => 'required',
            //'proveedor_id' => 'required',
            'purchase_id' => 'required',
            'purchase_year' => 'required',
            'status_id' => 'required|max:50',
            'condition_id' => 'required|max:50',
            'value' => 'required',

        ]);
        
        if ($request->type_id == 1){
            $this->validate($request,[
                'serial' => 'required|max:50',
                'marca'  => 'required|max:50',
                'model' => 'required|max:50',

            ]);
            
            
        }
        
        $cantidad = 1;
        if ($request->type_id == 2)
            $cantidad = $request->quantity;
        if(is_null($cantidad))
            $cantidad = 1;
        if ($request->status_id == 10){
            $asset_inventary = new AssetInventary;
        }
        while ($cantidad > 0) {
        
            $cantidad--;
            $asset = new Asset;
            /*
             * $asset->orden_compra = $request->orden_compra; 
             **/

            $asset->type_id = $request->type_id;
            $asset->category_id = $request->category_id;
            $asset->subcategory_id = $request->subcategory_id;
            $asset->specific_category_id = $request->specific_category_id;
            $asset->institution_id = $request->institution_id;
            $asset->proveedor_id = $request->proveedor_id;
            $asset->condition_id = $request->condition_id;
            $asset->purchase_id = $request->purchase_id;
            $asset->purchase_year = $request->purchase_year;
            $asset->status_id = $request->status_id;
            $asset->serial = $request->serial;
            $asset->marca = $request->marca;
            $asset->model = $request->model;
            $asset->value = $request->value;
            $asset->use_id = $request->use_id;

            if ($request->status_id == 10){


                    if ($request->type_id == 2){
                        $asset_inventary->exist = $cantidad;
                    }
                    
                    $asset_inventary->unit_value = $asset->value;
                    $asset_inventary->save();

                $asset->inventary_id = $asset_inventary->id;
                
            }

            $asset->save();
            $asset->serial_inventario = $asset->getCode();
            $asset->save();
        }

        return response()->json(['result' => true],200);
    }

    /**
     * Muestra el formulario para actualizar la información de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset  $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit($id)
    {
        $asset = Asset::find($id);
        return view('asset::registers.create', compact('asset'));
    }

    /**
     * Actualiza la información de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único del bien
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);
        $this->validate($request, [
            'type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'specific_category_id' => 'required',
            //'institution_id' => 'required',
            //'proveedor_id' => 'required',
            'purchase_id' => 'required',
            'purchase_year' => 'required',
            'status_id' => 'required|max:50',
            'condition_id' => 'required|max:50',
            'value' => 'required',

        ]);
        if ($request->type_id == 1){
            $this->validate($request,[
                'serial' => 'required|max:50',
                'marca'  => 'required|max:50',
                'model' => 'required|max:50',

            ]);
        }

        /*
         * $asset->orden_compra = $request->orden_compra; 
        **/
        
        $asset->type_id = $request->type_id;
        $asset->category_id = $request->category_id;
        $asset->subcategory_id = $request->subcategory_id;
        $asset->specific_category_id = $request->specific_category_id;
        $asset->institution_id = $request->institution_id;
        $asset->proveedor_id = $request->proveedor_id;
        $asset->condition_id = $request->condition_id;
        $asset->purchase_id = $request->purchase_id;
        $asset->purchase_year = $request->purchase_year;
        $asset->serial = $request->serial;
        $asset->marca = $request->marca;
        $asset->model = $request->model;
        $asset->value = $request->value;
        $asset->use_id = $request->use_id;

        // Si el bien registrado estaba en el alamacen
        if ($asset->status_id == 10)    {
            $asset_inventary = AssetInventary::find($asset->inventary_id);
            
            // Si despues de realizar cambios sigue en almacen
            if ($request->status_id == 10)    {
                
                $asset_inventary->unit_value = $asset->value;
                $asset_inventary->save();

            // Si despues de realizar los cambios el bien no esta en almacen
                
            }else if ($request->status_id != 10)  {

                if($asset_inventary->exist > 0)
                    $asset_inventary->exist--;
                
                $asset_inventary->unit_value = $asset->value;
                $asset_inventary->save();
            }

        
        // Si el bien registrado no estaba en el almacen antes de realizar los cambios
        }else if ($asset->status_id != 10)   {

            // Si se quiere guardar en el almacen
            if ($request->status_id == 10)    {
            
                if( !is_null($asset->inventary_id) ){
                    $asset_inventary = AssetInventary::find($asset->inventary_id);
                    $asset_inventary->exist++;
                }
                else
                    $asset_inventary = new AssetInventary;

                $asset_inventary->unit_value = $asset->value;
                $asset_inventary->save();
                $asset->inventary_id = $asset_inventary->id;
            }
        }

        $asset->status_id = $request->status_id;

        $asset->save();
        return response()->json(['result' => true],200);
    }

    /**
     * Elimina un Bien Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return response()->json(['record' => $asset, 'message' => 'destroy'], 200);
    }

    public function vueInfo($id)
    {

        $asset = Asset::where('id',$id)->with('type','category','subcategory','specific','purchase','condition','status','use')->first();

        return response()->json(['records' => $asset]);
        
    }

    public function vueList()
    {
        return response()->json(['records' => Asset::with('condition','status')->get()], 200);
    }

    public function searchAsset(Request $request){
        $assets = Asset::AssetClasification($request->case,$request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        return response()->json(['records' => $assets], 200);

    }

}
