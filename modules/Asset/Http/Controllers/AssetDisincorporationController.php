<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\UploadImageRepository;
use App\Repositories\UploadDocRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\CodeSetting;

use Modules\Asset\Models\AssetDisincorporationAsset;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\Asset;
use App\Models\Profile;

/**
 * @class     AssetDisincorporationController
 * @brief     Controlador de las desincorporaciones de bienes institucionales
 *
 * Clase que gestiona las desincorporaciones de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetDisincorporationController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.disincorporation.list', ['only' => 'index']);
        $this->middleware('permission:asset.disincorporation.create', ['only' =>['create', 'assetDisassign', 'store']]);
        $this->middleware('permission:asset.disincorporation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.disincorporation.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las Ddsincorporaciones de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function index()
    {
        return view('asset::disincorporations.list');
    }

    /**
     * Muestra el formulario para registrar una nueva desincorporación de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function create()
    {
        return view('asset::disincorporations.create');
    }

    /**
    * Valida y registra una nueva desincorporación de bienes institucionales
    *
    * @author    Henry Paredes <hparedes@cenditel.gob.ve>
    * @param     \Illuminate\Http\Request         $request    Datos de la petición
    * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar)
    */
    public function store(Request $request, UploadImageRepository $upImage, UploadDocRepository $upDoc)
    {
        $this->validate($request, [
            'date'                             => ['required'],
            'asset_disincorporation_motive_id' => ['required'],
            'observation'                      => ['required'],
            'files.*'                          => ['required', 'max:5000', 'mimes:jpeg,jpg,png,pdf,docx,doc,odt']

        ]);

        $codeSetting = CodeSetting::where('table', 'asset_disincorporations')->first();
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

        /**
         * Objeto asociado al modelo AssetDisincorporation
         *
         * @var Object $disincorporation
         */
        $disincorporation = AssetDisincorporation::create([
            'code' => $code,
            'date' => $request->date,
            'asset_disincorporation_motive_id' => $request->asset_disincorporation_motive_id,
            'observation' => $request->observation,
            'user_id' => Auth::id()
        ]);

        $assets = explode(",", $request->assets);
        foreach ($assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::create([
                'asset_id' => $asset->id,
                'asset_disincorporation_id' => $disincorporation->id,
            ]);
        }

        /** Se guardan los docmentos, según sea el tipo (imágenes y/o documentos)*/
        $documentFormat = ['doc', 'docx', 'pdf', 'odt'];
        $imageFormat    = ['jpeg', 'jpg', 'png'];
        if ($request->files) {
            foreach ($request->file('files') as $file) {
                $extensionFile = $file->getClientOriginalExtension();

                if (in_array($extensionFile, $documentFormat)) {
                    $upDoc->uploadDoc(
                        $file,
                        'documents',
                        AssetDisincorporation::class,
                        $disincorporation->id
                    );
                } elseif (in_array($extensionFile, $imageFormat)) {
                    $upImage->uploadImage(
                        $file,
                        'pictures',
                        AssetDisincorporation::class,
                        $disincorporation->id
                    );
                }
            }
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.disincorporation.index')], 200);
    }


    /**
     * Muestra el formulario para desincorporar un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id    Identificador único del bien a desincorporar
     * @return    Renderable    Objeto con los registros a mostrar
     */
    public function assetDisassign($id)
    {
        $asset = Asset::find($id);
        return view('asset::disincorporations.create', compact('asset'));
    }

    /**
     * Muestra el formulario para actualizar la información de las desincorporaciones de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id    Identificador único de la desincorporación a editar
     * @return    Renderable    Objeto con los datos a mostrar
     */
    public function edit($id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        return view('asset::disincorporations.create', compact('disincorporation'));
    }

    /**
     * Actualiza la información de las desincorporaciones de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único de la desincorporación
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $disincorporation = AssetDisincorporation::find($id);
        $this->validate($request, [
            'date' => ['required'],
            'asset_disincorporation_motive_id' => ['required'],
            'observation' => ['required']

        ]);

        $disincorporation->date = $request->date;
        $disincorporation->asset_disincorporation_motive_id = $request->asset_disincorporation_motive_id;
        $disincorporation->observation = $request->observation;
        $disincorporation->save();

        $update = now();
        /** Se agregan los nuevos elementos a la solicitud */
        foreach ($request->assets as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->asset_status_id = 7;
            $asset->save();
            $asset_disincorporation = AssetDisincorporationAsset::updateOrCreate([
                    'asset_id' => $asset->id,
                    'asset_disincorporation_id' => $disincorporation->id,
                    'updated_at' => $update
                ]);
        }
        /** Se eliminan los demas elementos de la solicitud */
        $assets_disincorporation = AssetDisincorporationAsset::where('asset_disincorporation_id', $disincorporation->id)
            ->where('updated_at', '!=', $update)->get();

        foreach ($assets_disincorporation as $asset_disincorporation) {
            $asset = Asset::find($asset_disincorporation->asset_id);
            $asset->asset_status_id = 10;
            $asset->save();

            $asset_disincorporation->delete();
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.disincorporation.index')], 200);
    }

    /**
     * Elimina una desincorporación de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetDisincorporation    $disincorporation    Datos de la desincorporación
     *                                                                                de un bien
     * @return    \Illuminate\Http\JsonResponse                  Objeto con los registros a mostrar
     */
    public function destroy(AssetDisincorporation $disincorporation)
    {
        $disincorporation->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza la información de la desincorporación de un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id    Identificador único de la desincorporación
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $disincorporation = AssetDisincorporation::where('id', $id)
            ->with(['assetDisincorporationMotive' ,'assetDisincorporationAssets' =>
            function ($query) {
                $query->with(['asset' =>
                function ($query) {
                    $query->with(
                        'assetType',
                        'assetCategory',
                        'assetSubcategory',
                        'assetSpecificCategory',
                        'assetAcquisitionType',
                        'assetCondition',
                        'assetStatus',
                        'assetUseFunction'
                    );
                }]);
            }])->first();

        return response()->json(['records' => $disincorporation], 200);
    }

    /**
     * Otiene un listado de las desincorporaciones registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $user_profile = Profile::where('user_id', auth()->user()->id)->first();
        $institution_id = isset($user_profile->institution_id)
            ? $user_profile->institution_id
            : null;

        if (Auth()->user()->isAdmin()) {
            $assetDisincorporations = AssetDisincorporation::with('assetDisincorporationMotive')->get();
        } else {
            $assetDisincorporations = AssetDisincorporation::where('institution_id', $institution_id)
                ->with('assetDisincorporationMotive')->get();
        }

        return response()->json(
            ['records' => $assetDisincorporations],
            200
        );
    }

    /**
     * Otiene un listado de los motivos de las desincorporaciones registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Array con los registros a mostrar
     */
    public function getAssetDisincorporationMotives()
    {
        return template_choices('Modules\Asset\Models\AssetDisincorporationMotive', 'name', '', true);
    }
}
