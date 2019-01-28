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
        $asset_requests = AssetRequest::all();
        $types = [
                'Seleccione...',
                'Prestamo de Equipos (Uso Interno)',
                'Prestamo de Equipos (Uso Externo)',
                'Prestamo de Equipos para Agentes Externos'];
        return view('asset::requests.list', compact('asset_requests','types'));
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create(Request $request, $type=0)
    {
        $header = [
            'route' => 'asset.request.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        $assets = Asset::request($request->model,$request->marca,$request->serial)->get();

        return view('asset::requests.create',compact('header','request','assets','type'));
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

            'type' => 'required',
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
        $datos = explode(',',$request->ids);
        $cantidad = 0;

        $data = new AssetRequest;


        $data->type = $request->type;
        $data->motive = $request->motive;
        $data->state = 'Pendiente';
        $data->delivery_date = $request->delivery_date;
        $data->ubication = $request->ubication;
        $data->agent_name = $request->agent_name;
        $data->agent_telf = $request->agent_telf;
        $data->agent_email = $request->agent_email;
        $data->save();

        while ($cantidad < count($datos)) {
            $seleccionados = new AssetRequested;
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            $asset->status_id = 6;
            $seleccionados->inventary_id = $asset->inventary_id;
            $seleccionados->asset_id = $asset->id;
            $seleccionados->request_id = $data->id;

            $seleccionados->save();
            $asset->save();
            $cantidad++;

        }

        
        return redirect()->route('asset.request.index');
    }

    /**
     * Muestra los datos de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetRequest  $request (Datos de la solicitud de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    
    public function show(AssetRequest $request)
    {
    }

    /**
     * Muestra el formulario para actualizar la información de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetRequest  $request (Datos de la Solicitud de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */

    public function edit($id,$type=0)
    {
        $request = AssetRequest::find($id);
        $header = [
            'route' => ['asset.request.update', $request->id], 'method' => 'PUT', 'role' => 'form', 'id' => 'form', 'class' => 'form-horizontal',
        ];
        $assets = Asset::all();
        $select = AssetRequested::where('request_id',$request->id)->get();
        $data = [];
        $index=0;
        foreach ($select as $key) {            
            $asset = Asset::find($key->asset_id);
            $data[$index]= $asset->serial_inventario;
            $index++;
        }
        $select =json_encode($data);

        $type = $request->type;
        

        return view('asset::requests.create',compact('header','assets','request','select','type'));
    }

    /**
     * Actualiza la información de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetRequest  $data (Datos de la solicitud de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function update(Request $request, $id)
    {
        //Validar que no se realizaron cambios
        $data = AssetRequest::find($id);
        $this->validate($request, [

            'type' => 'required',
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

        $datos = explode(' , ',$request->ids);
        $cantidad = 0;

        $data->type = $request->type;
        $data->motive = $request->motive;
        $data->delivery_date = $request->delivery_date;
        $data->ubication = $request->ubication;
        $data->agent_name = $request->agent_name;
        $data->agent_telf = $request->agent_telf;
        $data->agent_email = $request->agent_email;
        $data->save();

        $seleccionados = AssetRequested::where('request_id',$data->id)->get();

        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        
        foreach ($seleccionados as $requested) {
            $old_asset = $requested->asset()->first();
            $serial = $old_asset->serial_inventario;
            $clave = in_array($serial, $datos);
            if ($clave === false ){
                $old_asset->status_id = 10;
                $requested->delete();
                $old_asset->save();
            }
        }
        
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */

        while ($cantidad < count($datos)) {          
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            $new_asset = $seleccionados->where('asset_id',$asset->id)->first();
            if (is_null($new_asset)){
                $new_asset = new AssetRequested;
                $asset->status_id = 6;
                $new_asset->inventary_id = $asset->inventary_id;
                $new_asset->asset_id = $asset->id;
                $new_asset->request_id = $data->id;
            
                $new_asset->save();
                $asset->save();
            }                
            $cantidad++;

        }
     
        return redirect()->route('asset.request.index');
    }

    /**
     * Elimina una Solicitud de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetRequest $request (Datos de la Solicitud de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $request = AssetRequest::find($id);
        $assets_requested = AssetRequested::where('request_id', $request->id)->get();
        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->status_id = 10;
            $asset->save();
            $requested->delete();
        }
        $request->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    public function info(AssetRequest $request){

        $dato = AssetRequest::find($request->id);
        $types = [
                'Seleccione...',
                'Prestamo de Equipos (Uso Interno)',
                'Prestamo de Equipos (Uso Externo)',
                'Prestamo de Equipos para Agentes Externos'];
        $this->data_list[] = [
            'id' => $dato->id,
            'type' => $types[$dato->type],
            'date_init' => isset($dato->created_at)?$dato->created_at->format('d-m-Y'):null,
            'motive' => $dato->motive,
            'delivery_date' => isset($dato->delivery_date)?$dato->delivery_date:'N/A',
            'ubication' => $dato->ubication,
            'agent_name' => $dato->agent_name,
            'agent_telf' => $dato->agent_telf,
            'agent_email' => $dato->agent_email
        ];

        return response()->json(['record' => $this->data_list[0]]);

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
        $assets_requested = AssetRequested::where('request_id', $request->id)->get();
        
        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->status_id = 10;
            $asset->save();
        }
        return back();
    }

    public function vueInfo($id){
        $asset_request = AssetRequested::where('request_id',$id)->with('asset')->get();

        return response()->json(['records' => $asset_request], 200);
    }
}
