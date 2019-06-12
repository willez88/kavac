<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetAsignation;
use Modules\Asset\Models\AssetAsignationAsset;
use Modules\Asset\Models\Asset;

/**
 * @class AssetAsignationController
 * @brief Controlador de Asignaciones de Bienes Institucionales
 * 
 * Clase que gestiona las Asignaciones de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetAsignationController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.asignation.list', ['only' => 'index']);
        $this->middleware('permission:asset.asignation.create', ['only' => ['create', 'Asset_Assign', 'store']]);
        $this->middleware('permission:asset.asignation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.asignation.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $asset_asignations = AssetAsignation::all();
        return view('asset::asignations.list', compact('asset_asignations'));
    }

    /**
     * Muestra el formulario para registrar una nueva Asignación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('asset::asignations.create');
    }

    /**
     * Muestra el formulario para registrar una nueva Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del bien a asignar
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function Asset_Assign($id)
    {
        $asset = Asset::find($id);
        return view('asset::asignations.create', compact('asset'));
    }

    /**
     * Valida y Registra una nueva Asignación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            //'ubication' => 'required',
            //'staff_id' => 'required',

        ]);
        $asignation = AssetAsignation::create([
                'staff_id' => $request->staff_id,
        ]);

        foreach ($request->assets as $product) {
            $asset = Asset::find($product);
            $asset->status_id = 1;
            $asset->save();
            $asset_asignation = AssetAsignationAsset::create([
                'asset_id' => $asset->id,
                'asignation_id' => $asignation->id,
            ]);
        }
        return response()->json(['result' => true], 200);

    }

    /**
     * Muestra el formulario para actualizar la información de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation  $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit($id)
    {
        $asignation = AssetAsignation::find($id);
        return view('asset::asignations.create', compact('asignation'));
    }

    /**
     * Actualiza la información de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único de la asignación
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $asignation = AssetAsignation::where('id', $id)->with('assetsAsignation')->first();
        $asignation->staff_id = $request->staff_id;
        $asignation->save();
    
        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        $assets_asignation = AssetAsignationAsset::where('asignation_id', $asignation->id)->get();

        foreach ($assets_asignation as $asset_asignation) {
            $asset = Asset::find($asset_asignation->asset_id);
            $datos = $request->assets;
            $clave = in_array($asset->id, $datos);
            if ($clave == false){
                $asset->status_id = 10;
                $asset->save();
                $asset_asignation->delete();
            }
        }
    
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->status_id = 1;
            $asset->save();
            $asset_asignation = AssetAsignationAsset::where('asset_id', $asset->id)->where('asignation_id',$asignation->id)->first();
            if( is_null($asset_asignation))
                $asset_asignation = AssetAsignationAsset::create([
                    'asset_id' => $asset->id,
                    'asignation_id' => $asignation->id,
                ]);

        }
        
        return response()->json(['result' => true],200);
    }

    /**
     * Elimina una Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetAsignation $asignation)
    {
        $asignation->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualizar Información de la Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id){
        $asignation = AssetAsignation::where('id',$id)
            ->with(['staff','assetsAsignation' => 
                function($query){
                    $query->with(['asset' =>
                    function($query){
                        $query->with('type','category',
                                     'subcategory','specific',
                                     'purchase','condition','status','use');
                    }]);
                }])->first();

        return response()->json(['records' => $asignation], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => AssetAsignation::with('staff')->get()], 200);
    }

}
