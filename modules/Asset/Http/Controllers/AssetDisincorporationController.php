<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Asset\Models\AssetDisincorporationAsset;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\Asset;

/**
 * @class AssetDisincorporationController
 * @brief Controlador de Desincorporaciones de Bienes Institucionales
 * 
 * Clase que gestiona las Desincorporaciones de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetDisincorporationController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.disincorporation.list', ['only' => 'index']);
        $this->middleware('permission:asset.disincorporation.create', ['only' => ['create', 'Asset_Disassign', 'store']]);
        $this->middleware('permission:asset.disincorporation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.disincorporation.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $asset_disincorporations = AssetDisincorporation::all();
        return view('asset::disincorporations.list', compact('asset_disincorporations'));
    }

    /**
     * Muestra el formulario para registrar una nueva Desincorporación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('asset::disincorporations.create');
    }

     /**
     * Valida y Registra una nueva Desincorporación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'motive_id' => 'required',
            'observation' => 'required'

        ]);

        $disincorporation = AssetDisincorporation::create([
            'date' => $request->date,
            'motive_id' => $request->motive_id,
            'observation' => $request->observation
        ]);

        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::create([
                'asset_id' => $asset->id,
                'disincorporation_id' => $disincorporation->id,
            ]);
        }
        return response()->json(['result' => true], 200);
    }

    
    /**
     * Muestra el formulario para Desincorporar un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer $id Identificador único del bien a desincorporar
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function Asset_Disassign($id)
    {
        $asset = Asset::find($id);
        return view('asset::disincorporations.create', compact('asset'));
        }

    /**
     * Muestra el formulario para actualizar la información de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  Integer  $id Identificador único de la desincorporación a editar
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit($id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        return view('asset::disincorporations.create', compact('disincorporation'));
    }

    /**
     * Actualiza la información de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetDisincorporation  $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        $this->validate($request, [
            'date' => 'required',
            'motive_id' => 'required',
            'observation' => 'required'

        ]);

        $disincorporation->date = $request->date;
        $disincorporation->observation = $request->observation;
        $disincorporation->save();

        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        $assets_disincorporation = AssetDisincorporationAsset::where('disincorporation_id', $disincorporation->id)->get();
        foreach ($assets_disincorporation as $asset_disincorporation) {
            $asset = Asset::find($asset_disincorporation->asset_id);
            $datos = $request->assets;
            $clave = in_array($asset->id, $datos);
            if ($clave == false){
                $asset->status_id = 10;
                $asset->save();
                $asset_disincorporation->delete();
            }
        }
    
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::where('asset_id', $asset->id)->where('disincorporation_id',$disincorporation->id)->first();
            if( is_null($asset_disincorporation))
                $asset_disincorporation = AssetDisincorporationAsset::create([
                    'asset_id' => $asset->id,
                    'disincorporation_id' => $disincorporation->id,
                ]);

        }
        return response()->json(['result' => true],200);
    }

    /**
     * Elimina una Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetDisincorporation $disincorporation)
    {
        $disincorporation->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza la Información de la Desincorporación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function vueInfo($id){
        $disincorporation = AssetDisincorporation::where('id',$id)
            ->with(['assetsDisincorporation' => 
                function($query){
                    $query->with(['asset' =>
                    function($query){
                        $query->with('type','category',
                                     'subcategory','specific',
                                     'purchase','condition','status','use');
                    }]);
                }])->first();

        return response()->json(['records' => $disincorporation], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => AssetDisincorporation::with('motive')->get()], 200);
    }

}
