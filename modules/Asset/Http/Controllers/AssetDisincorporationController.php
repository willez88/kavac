<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Asset\Models\AssetDisincorporationAsset;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\Asset;

/**
 * @class AssetDisincorporationController
 * @brief Controlador de las desincorporaciones de bienes institucionales
 * 
 * Clase que gestiona las desincorporaciones de bienes institucionales
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetDisincorporationController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.disincorporation.list', ['only' => 'index']);
        $this->middleware('permission:asset.disincorporation.create', ['only' => ['create', 'Asset_Disassign', 'store']]);
        $this->middleware('permission:asset.disincorporation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.disincorporation.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las Ddsincorporaciones de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('asset::disincorporations.list');
    }

    /**
     * Muestra el formulario para registrar una nueva desincorporación de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('asset::disincorporations.create');
    }

     /**
     * Valida y registra una nueva desincorporación de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'asset_disincorporation_motive_id' => 'required',
            'observation' => 'required'

        ]);

        $codeSetting = CodeSetting::where('table', 'asset_disincorporations')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('asset.setting.index')], 200);
        }

        $code  = generate_registration_code($codeSetting->format_prefix, strlen($codeSetting->format_digits),
        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'), $codeSetting->model, $codeSetting->field);

        $disincorporation = AssetDisincorporation::create([
            'code' => $code,
            'date' => $request->date,
            'asset_disincorporation_motive_id' => $request->asset_disincorporation_motive_id,
            'observation' => $request->observation,
            'user_id' => Auth::id()
        ]);

        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::create([
                'asset_id' => $asset->id,
                'asset_disincorporation_id' => $disincorporation->id,
            ]);
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.disincorporation.index')], 200);
    }

    
    /**
     * Muestra el formulario para desincorporar un bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único del bien a desincorporar
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function asset_disassign($id)
    {
        $asset = Asset::find($id);
        return view('asset::disincorporations.create', compact('asset'));
    }

    /**
     * Muestra el formulario para actualizar la información de las desincorporaciones de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer]  $id                   Identificador único de la desincorporación a editar
     * @return \Illuminate\Http\JsonResponse    Objeto con los datos a mostrar
     */
    public function edit($id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        return view('asset::disincorporations.create', compact('disincorporation'));
    }

    /**
     * Actualiza la información de las desincorporaciones de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @param  [Integer] $id                        Identificador único de la desincorporación
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        $this->validate($request, [
            'date' => 'required',
            'asset_disincorporation_motive_id' => 'required',
            'observation' => 'required'

        ]);

        $disincorporation->date = $request->date;
        $disincorporation->asset_disincorporation_motive_id = $request->asset_disincorporation_motive_id;
        $disincorporation->observation = $request->observation;
        $disincorporation->save();

        /** Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */

        $assets_disincorporation = AssetDisincorporationAsset::where('asset_disincorporation_id', $disincorporation->id)->get();
        foreach ($assets_disincorporation as $asset_disincorporation) {
            $asset = Asset::find($asset_disincorporation->asset_id);
            $datos = $request->assets;
            $clave = in_array($asset->id, $datos);
            if ($clave == false){
                $asset->asset_status_id = 10;
                $asset->save();
                $asset_disincorporation->delete();
            }
        }
    
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::where('asset_id', $asset->id)->where('asset_disincorporation_id',$disincorporation->id)->first();
            if( is_null($asset_disincorporation))
                $asset_disincorporation = AssetDisincorporationAsset::create([
                    'asset_id' => $asset->id,
                    'asset_disincorporation_id' => $disincorporation->id,
                ]);

        }
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.disincorporation.index')], 200);
    }

    /**
     * Elimina una desincorporación de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation    Datos de la desincorporación de un bien
     * @return \Illuminate\Http\JsonResponse                                    Objeto con los registros a mostrar
     */
    public function destroy(AssetDisincorporation $disincorporation)
    {
        $disincorporation->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza la información de la desincorporación de un bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                  Identificador único de la desincorporación
     * @return \Illuminate\Http\JsonResponse  Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $disincorporation = AssetDisincorporation::where('id',$id)
            ->with(['asset_disincorporation_motive' ,'asset_disincorporation_assets' => 
            function($query) {
                $query->with(['asset' =>
                function($query) {
                    $query->with('asset_type', 'asset_category',
                        'asset_subcategory', 'asset_specific_category',
                        'asset_acquisition_type', 'asset_condition', 'asset_status',
                        'asset_use_function');
                }]);
            }])->first();

        return response()->json(['records' => $disincorporation], 200);
    }

    /**
     * Otiene un listado de las desincorporaciones registradas
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        return response()->json(['records' => AssetDisincorporation::with('asset_disincorporation_motive')->get()], 200);
    }

    /**
     * Otiene un listado de los motivos de las desincorporaciones registradas
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return [array] Array con los registros a mostrar
     */
    public function getAssetDisincorporationMotives(){
        return template_choices('Modules\Asset\Models\AssetDisincorporationMotive','name','',true);
    }

}
