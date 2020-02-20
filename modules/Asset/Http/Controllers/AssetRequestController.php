<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\CodeSetting;
use Session;

use Modules\Asset\Models\AssetRequestDelivery;
use Modules\Asset\Models\AssetRequestExtension;
use Modules\Asset\Models\AssetRequestAsset;
use Modules\Asset\Models\AssetRequest;
use Modules\Asset\Models\Asset;
use App\Models\Profile;

/**
 * @class AssetRequestController
 * @brief Controlador de las solicitudes de bienes institucionales
 *
 * Clase que gestiona las solicitudes de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequestController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];
    
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.request.list', ['only' => 'index']);
        $this->middleware('permission:asset.request.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset.request.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.request.delete', ['only' => 'destroy']);

        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Muestra un listado de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('asset::requests.list');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('asset::requests.create');
    }

    /**
     * Valida y registra una nueva solicitud de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_id' => ['required'],
            'motive' => ['required'],
            'delivery_date' => ['required'],

        ]);

        if ($request->type == 2) {
            $this->validate($request, [
                'ubication'  => ['required'],
            ]);
        }
        if ($request->type == 3) {
            $this->validate($request, [
                'ubication'  => ['required'],
                'agent_name' => ['required'],
                'agent_telf' => ['required'],
                'agent_email' => ['required'],
            ]);
        }

        $codeSetting = CodeSetting::where('table', 'asset_requests')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('asset.setting.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        $asset_request = AssetRequest::create([
            'code' => $code,
            'type' => $request->type_id,
            'motive' => $request->motive,
            'state' => 'Pendiente',
            'delivery_date' => $request->delivery_date,
            'ubication' => $request->ubication,
            'agent_name' => $request->agent_name,
            'agent_telf' => $request->agent_telf,
            'agent_email' => $request->agent_email,
            'user_id' => Auth::id()
        ]);

        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 6;
            $asset->save();
            $asset_request_asset = AssetRequestAsset::create([
                'asset_id' => $asset->id,
                'asset_request_id' => $asset_request->id,
            ]);
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    /**
     * Muestra el formulario para actualizar la información de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse    Objeto con los datos a mostrar
     */
    public function edit($id)
    {
        $request = AssetRequest::find($id);
        return view('asset::requests.create', compact('request'));
    }

    /**
     * Actualiza la información de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @param  [Integer] $id                        Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $asset_request = AssetRequest::find($id);
        
        $this->validate($request, [
            'type_id' => ['required'],
            'motive' => ['required'],
            'delivery_date' => ['required'],
        ]);

        if ($request->type == 2) {
            $this->validate($request, [
                'ubication'  => ['required'],
            ]);
        }
        if ($request->type == 3) {
            $this->validate($request, [
                'ubication'  => ['required'],
                'agent_name' => ['required'],
                'agent_telf' => ['required'],
                'agent_email' => ['required'],
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


        $update = now();
        /** Se agregan los nuevos elementos a la solicitud */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 6;
            $asset->save();
            $requested = AssetRequestAsset::updateOrCreate([
                    'asset_id' => $asset->id,
                    'asset_request_id' => $asset_request->id,
                    'updated_at' => $update
                ]);
        }
        /** Se eliminan los demas elementos de la solicitud */
        $asset_request_assets = AssetRequestAsset::where('asset_request_id', $asset_request->id)
            ->where('updated_at', '!=', $update)->get();

        foreach ($asset_request_assets as $asset_request_asset) {
            $asset = Asset::find($asset_request_asset->asset_id);
            $asset->asset_status_id = 10;
            $asset->save();
            
            $asset_request_asset->delete();
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    /**
     * Elimina una solicitud de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetRequest $request  Datos de la solicitud de un bien
     * @return \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function destroy(AssetRequest $request)
    {
        $assetRequestExtensions = AssetRequestExtension::where('asset_request_id', $request->id)->get();
        foreach ($assetRequestExtensions as $assetRequestExtension) {
            $assetRequestExtension->delete();
        }
        $assetRequestDeliveries = AssetRequestDelivery::where('asset_request_id', $request->id)->get();
        foreach ($assetRequestDeliveries as $assetRequestDelivery) {
            $assetRequestDelivery->delete();
        }
        $request->delete();
        Session()->flash('message', ['type' => 'destroy']);
        return response()->json(['redirect' => route('asset.request.index')], 200);
    }

    /**
     * Otiene un listado de las solicitudes registradas
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $user_profile = Profile::where('user_id', auth()->user()->id)->first();
        $institution_id = isset($user_profile->institution_id)
            ? $user_profile->institution_id
            : null;

        if (Auth()->user()->isAdmin()) {
            $assetRequests = AssetRequest::all();
        } else {
            $assetRequests = AssetRequest::where('institution_id', $institution_id)->get();
        }

        return response()->json(['records' => $assetRequests ], 200);
    }

    /**
     * Otiene un listado de las solicitudes pendientes por ejecutar
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vuePendingList()
    {
        $user_profile = Profile::where('user_id', auth()->user()->id)->first();
        $institution_id = isset($user_profile->institution_id)
            ? $user_profile->institution_id
            : null;

        if (Auth()->user()->isAdmin()) {
            $assetRequests = AssetRequest::with('user')->where('state', 'Pendiente')->get();
        } else {
            $assetRequests = AssetRequest::with('user')
                ->where('institution_id', $institution_id)
                ->where('state', 'Pendiente')->get();
        }

        return response()->json(['records' => $assetRequests ], 200);
    }

    /**
     * Actualiza el estado de una solicitud a aprovado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                        Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function approved(Request $request, $id)
    {
        $asset_request = AssetRequest::find($id);
        $asset_request->state = 'Aprobado';
        $assets_requested = AssetRequestAsset::where('asset_request_id', $asset_request->id)->get();

        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->asset_status_id = 1;
            $asset->save();
        }
        $asset_request->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    /**
     * Actualiza el estado de una solicitud a rechazado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                        Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function rejected(Request $request, $id)
    {
        $asset_request = AssetRequest::find($id);
        $asset_request->state = 'Rechazado';
        $assets_requested = AssetRequestAsset::where('asset_request_id', $asset_request->id)->get();

        foreach ($assets_requested as $requested) {
            $asset = $requested->asset;
            $asset->asset_status_id = 10;
            $asset->save();
        }
        $asset_request->save();
        
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    /**
     * Actualiza el estado de una solicitud a entregado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                        Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function deliver(Request $request, $id)
    {
        $asset_request = AssetRequest::find($id);
        $asset_request->state = 'Procesando entrega';
        $asset_request->save();
        
        $request_delivery = AssetRequestDelivery::create([
            'state' => 'Pendiente',
            'asset_request_id' => $asset_request->id,
            'user_id' => Auth::id(),
        ]);
        
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    /**
     * Obtiene la información de la solicitud registrada
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $asset_request = AssetRequest::where('id', $id)->with(
            ['assetRequestAssets' => function ($query) {
                $query->with('asset');
            }]
        )->first();

        return response()->json(['records' => $asset_request], 200);
    }

    public function getTypes()
    {
        $this->data[1] = [
            'id' => 1,
            'text' => 'AVERIADO'
        ];
        $this->data[2] = [
            'id' => 2,
            'text' => 'PERDIDO'
        ];
        return response()->json($this->data);
    }

    public function getEquipments($id)
    {
        $assetRequest = AssetRequest::where('id', $id)->with(
            ['assetRequestAssets' => function ($query) {
                $query->with('asset');
            }]
        )->first();
        return $assetRequest->assetRequestAssets;
    }
}
