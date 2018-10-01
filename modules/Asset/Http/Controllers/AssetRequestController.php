<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetRequest;
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
        return view('asset::requests.list', compact('asset_requests'));
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create(Request $request)
    {
        $header = [
            'route' => 'asset.request.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];
        $assets= Asset::request($request->model,$request->marca,$request->serial)->get();
        return view('asset::requests.create',compact('header','assets'));
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
        if ($request->type == 1){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',

            ]);
        }
        if ($request->type == 2){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',
                'agent_name' => 'required',
                'agent_telf' => 'required',
                'agent_email' => 'required',

            ]);
        }
        $data = new AssetRequest;

        
        $data->type = $request->type;
        $data->motive = $request->motive;
        $data->delivery_date = $request->delivery_date;
        $data->ubication = $request->ubication;
        $data->agent_name = $request->agent_name;
        $data->agent_telf = $request->agent_telf;
        $data->agent_email = $request->agent_email;

        

        

        $data->save();
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
     */    public function edit(AssetRequest $request)
    {
        $header = [
            'route' => 'asset.request.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];
        $assets = Asset::all();
        return view('asset::requests.create',compact('header','assets','request'));
    }

    /**
     * Actualiza la información de las Solicitudes de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetRequest  $data (Datos de la solicitud de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, AssetRequest $data)
    {
        $this->validate($request, [

            'type' => 'required',
            'motive' => 'required',

        ]);
        if ($request->type == 1){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',

            ]);
        }
        if ($request->type == 2){
            $this->validate($request,[
                'delivery_date' => 'required',
                'ubication'  => 'required',
                'agent_name' => 'required',
                'agent_telf' => 'required',
                'agent_email' => 'required',

            ]);
        }

        $data->type = $request->type;
        $data->motive = $request->motive;
        $data->delivery_date = $request->delivery_date;
        $data->ubication = $request->ubication;
        $data->agent_name = $request->agent_name;
        $data->agent_telf = $request->agent_telf;
        $data->agent_email = $request->agent_email;

        

        $data->save();
        return redirect()->route('asset.request.index');
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
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
