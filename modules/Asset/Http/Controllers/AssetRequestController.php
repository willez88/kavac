<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetRequest;
use Modules\Asset\Models\AssetRequested;
use Modules\Asset\Models\Asset;


/**
 * @class AssetRequestController
 * @brief Controlador de Solicitudes de Bienes Institucionales
 * 
 * Clase que gestiona las Solicitudes de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */


class AssetRequestController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.request.list', ['only' => 'index']);
        $this->middleware('permission:asset.request.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset.request.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.request.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return view('asset::requests.list');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('asset::requests.create');
    }

    /**
     * Valida y Registra una nueva Solicitud de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        

        $this->validate($request, [

            'type_id' => 'required',
            'motive' => 'required',

        ]);
        if ($request->type == 2){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',

            ]);
        }
        if ($request->type == 3){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',
                'agent_name' => 'required',
                'agent_telf' => 'required',
                'agent_email' => 'required',

            ]);
        }
        $asset_request = AssetRequest::create([
            'type' => $request->type_id,
            'motive' => $request->motive,
            'state' => 'Pendiente',
            'delivery_date' => $request->delivery_date,
            'ubication' => $request->ubication,
            'agent_name' => $request->agent_name,
            'agent_telf' => $request->agent_telf,
            'agent_email' => $request->agent_email

        ]);
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->status_id = 6;
            $asset->save();
            $asset_request_asset = AssetRequested::create([
                'asset_id' => $asset->id,
                'request_id' => $asset_request->id,
            ]);
        }
        return response()->json(['result' => true], 200);
    }

    /**
     * Muestra el formulario para actualizar la información de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetRequest  $request (Datos de la Solicitud de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */

    public function edit($id)
    {
        $request = AssetRequest::find($id);
        return view('asset::requests.create',compact('request'));
    }

    /**
     * Actualiza la información de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único de la solicitud
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function update(Request $request, $id)
    {
        $asset_request = AssetRequest::find($id);
        $this->validate($request, [

            'type_id' => 'required',
            'motive' => 'required',

        ]);
        if ($request->type == 2){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',

            ]);
        }
        if ($request->type == 3){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',
                'agent_name' => 'required',
                'agent_telf' => 'required',
                'agent_email' => 'required',

            ]);
        }

        $asset_request->type = $request->type_id;
        $asset_request->motive = $request->motive;
        $asset_request->delivery_date = $request->delivery_date;
        $asset_request->ubication = $request->ubication;
        $asset_request->agent_name = $request->agent_name;
        $asset_request->agent_telf = $request->agent_telf;
        $asset_request->agent_email = $request->agent_email;
        $asset_request->save();

        
        $asset_request_asset = AssetRequested::where('request_id',$asset_request->id)->get();

        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        
        foreach ($asset_request_asset as $requested) {
            $asset = Asset::find($requested->asset_id);
            $datos = $request->assets;
            $clave = in_array($asset->id, $datos);
            if ($clave === false ){
                $asset->status_id = 10;
                $asset->save();
                $requested->delete();
            }
        }

        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->status_id = 6;
            $asset->save();
            $requested = AssetRequested::where('asset_id', $asset->id)->where('request_id',$asset_request->id)->first();
            if( is_null($requested))
                $requested = AssetRequested::create([
                    'asset_id' => $asset->id,
                    'request_id' => $asset_request->id,
                ]);

        }
        return response()->json(['result' => true],200);
    }

    /**
     * Elimina una Solicitud de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetRequest $request (Datos de la Solicitud de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetRequest $request)
    {
        $request->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => AssetRequest::all()], 200);
    }

    public function vuePendingList()
    {
        return response()->json(['records' => AssetRequest::where('state','Pendiente')->get()], 200);
    }

    public function approved($id)
    {
        $request = AssetRequest::find($id);
        $request->state = 'Aprobado';

        $assets_requested = AssetRequested::where('request_id', $request->id)->get();
        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->status_id = 1;
            $asset->save();
        }
        $request->save();

        return response()->json(['records' => AssetRequest::where('state','Pendiente')->get()], 200);
    }
    public function rejected($id)
    {
        $request = AssetRequest::find($id);
        $request->state = 'Rechazado';
        
        $assets_requested = AssetRequested::where('request_id', $request->id)->get();
        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->status_id = 10;
            $asset->save();
        }
        $request->save();
        return response()->json(['records' => AssetRequest::where('state','Pendiente')->get()], 200);
    }

    public function deliver($id)
    {
        $request = AssetRequest::find($id);
        $request->state = 'Entregados';
        $request->save();
        
        $assets_requested = AssetRequested::where('request_id', $request->id)->get();
        
        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->status_id = 10;
            $asset->save();
        }
        response()->json(['message' => 'update'], 200);
    }

    public function vueInfo($id){
        $asset_request = AssetRequest::where('id',$id)->with([
            'assets' => function($query) {
                $query->with('asset');
            }
        ])->first();

        return response()->json(['records' => $asset_request], 200);
    }
}
