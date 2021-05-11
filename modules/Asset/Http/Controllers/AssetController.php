<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Jobs\AssetCreateAssets;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Asset\Exports\AssetExport;
use Modules\Asset\Imports\AssetImport;
use Modules\Asset\Rules\AcquisitionYear;
use Modules\Asset\Rules\RequiredItem;
use Modules\Asset\Models\AssetRequest;
use Modules\Asset\Models\AssetAsignation;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\AssetRequiredItem;
use Modules\Asset\Models\Asset;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

/**
 * @class      AssetController
 * @brief      Controlador de bienes institucionales
 *
 * Clase que gestiona los bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;
    /**
     * Define la configuración de la clase
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->validateRules = [
            'asset_type_id' => ['required'],
            'asset_category_id' => ['required'],
            'asset_subcategory_id' => ['required'],
            'asset_specific_category_id' => ['required'],
            'asset_acquisition_type_id' => ['required'],
            'acquisition_date' => ['required', new AcquisitionYear(Date("Y"))],
            'asset_status_id' => ['required'],
            'asset_condition_id' => ['required'],
            'value' => ['required', 'regex:/^\d+(\.\d+)?$/u'],
            'currency_id' => ['required'],
            'institution_id' => ['required'],
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'institution_id'                       => 'El campo organización es obligatorio.',
            'aseet_type_id.required'               => 'El campo tipo de bien es obligatorio.',
            'aseet_category_id.required'           => 'El campo categoria general es obligatorio.',
            'aseet_subcategory_id.required'        => 'El campo subcategoria es obligatorio.',
            'aseet_specific_category_id.required'  => 'El campo categoria especifica es obligatorio.',
            'asset_acquisition_type_id'            => 'El campo forma de adquisición es obligatorio.',
            'acquisition_date'                     => 'El campo fecha de adquisición es obligatorio.',
            'asset_status_id'                      => 'El campo estatus de uso es obligatorio.',
            'value'                                => 'El campo valor es obligatorio.',
            'currency_id'                          => 'El campo moneda es obligatorio.',
            'serial'                               => 'El campo serial es obligatorio.',
            'marca'                                => 'El campo marca es obligatorio.',
            'model'                                => 'El campo modelo es obligatorio.',
            'asset_use_function_id'                => 'El campo función de uso es obligatorio.',
            'parish_id'                            => 'El campo país es obligatorio.',
            'address'                              => 'El campo dirección es obligatorio.',





        ];
    }

    /**
     * Muestra un listado de los bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function index()
    {
        return view('asset::registers.list');
    }

    /**
     * Muestra el formulario para registrar un nuevo bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function create()
    {
        return view('asset::registers.create');
    }

    /**
     * Valida y registra un nuevo bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $item_required = AssetRequiredItem::where('asset_specific_category_id', $request->asset_specific_category_id)
            ->first();
        if (!is_null($item_required)) {
            $validateRules  = $this->validateRules;
            $validateRules  = array_merge(
                $validateRules,
                [
                    'serial' => new RequiredItem($item_required->serial),
                    'marca'  => new RequiredItem($item_required->marca),
                    'model' => new RequiredItem($item_required->model),
                    'asset_use_function_id' => new RequiredItem($item_required->use_function),
                    'parish_id' => new RequiredItem($item_required->address),
                    'address' => new RequiredItem($item_required->address),

                ]
            );
            $this->validate($request, $validateRules, $this->messages);
        } else {
            $this->validate($request, $this->validateRules, $this->messages);
        }
        $asset = Asset::create([
            'asset_type_id'              => $request->asset_type_id,
            'asset_category_id'          => $request->asset_category_id,
            'asset_subcategory_id'       => $request->asset_subcategory_id,
            'asset_specific_category_id' => $request->asset_specific_category_id,
            'specifications'             => $request->specifications,
            'asset_condition_id'         => $request->asset_condition_id,
            'asset_acquisition_type_id'  => $request->asset_acquisition_type_id,
            'acquisition_date'           => $request->acquisition_date,
            'asset_status_id'            => $request->asset_status_id,
            'serial'                     => $request->serial,
            'marca'                      => $request->marca,
            'model'                      => $request->model,
            'value'                      => $request->value,
            'currency_id'                => $request->currency_id,
            'institution_id'             => $request->institution_id,
            'asset_use_function_id'      => $request->asset_use_function_id,
            'parish_id'                  => $request->parish_id,
            'address'                    => $request->address,

        ]);
        $asset->inventory_serial = $asset->getCode();
        $asset->save();

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.register.index')], 200);
    }

    /**
     * Muestra el formulario para actualizar la información de los bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\Asset    $asset    Datos del Bien
     * @return    Renderable
     */
    public function edit($id)
    {
        $asset = Asset::find($id);
        return view('asset::registers.create', compact('asset'));
    }

    /**
     * Actualiza la información de los bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único del bien
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);


        if ($request->asset_type_id == 1) {
            $validateRules  = $this->validateRules;
            $validateRules  = array_merge(
                $validateRules,
                [
                    'serial' => ['required', 'max:50'],
                    'marca'  => ['required', 'max:50'],
                    'model' => ['required', 'max:50'],

                ]
            );
        } elseif ($request->type_id == 2) {
            $validateRules  = $this->validateRules;
            $validateRules  = array_merge(
                $validateRules,
                [
                    'asset_use_function_id' => ['required'],
                    'parish_id' => ['required'],
                    'address' => ['required'],

                ]
            );
        }

        $asset->update([
            'asset_type_id'              => $request->asset_type_id,
            'asset_category_id'          => $request->asset_category_id,
            'asset_subcategory_id'       => $request->asset_subcategory_id,
            'asset_specific_category_id' => $request->asset_specific_category_id,
            'specifications'             => $request->specifications,
            'asset_condition_id'         => $request->asset_condition_id,
            'asset_acquisition_type_id'  => $request->asset_acquisition_type_id,
            'acquisition_date'           => $request->acquisition_date,
            'asset_status_id'            => $request->asset_status_id,
            'serial'                     => $request->serial,
            'marca'                      => $request->marca,
            'model'                      => $request->model,
            'value'                      => $request->value,
            'currency_id'                => $request->currency_id,
            'institution_id'             => $request->institution_id,
            'asset_use_function_id'      => $request->asset_use_function_id,
            'parish_id'                  => $request->parish_id,
            'address'                    => $request->address,

        ]);

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.register.index')], 200);
    }

    /**
     * Elimina un bien institucional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\Asset      $asset    Datos del Bien
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene la información del bien institucional registrado
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\Asset      $asset    Datos del bien institucional
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $asset = Asset::where('id', $id)->with(
            [
                'assetType',
                'assetCategory',
                'assetSubcategory',
                'assetSpecificCategory',
                'assetAcquisitionType',
                'assetCondition',
                'assetStatus',
                'assetUseFunction',
                'institution',
                'parish' => function ($query) {
                    $query->with(['municipality' => function ($query) {
                        $query->with(['estate' => function ($query) {
                            $query->with('country')->get();
                        }])->get();
                    }])->get();
                }
            ]
        )->first();

        return response()->json(['records' => $asset], 200);
    }

    /**
     * Otiene un listado de los bienes registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $perPage         Número de registros por página
     * @param     Integer                          $page            Número de la página seleccionada
     * @param     String                           $operation       Tipo de operación realizada
     * @param     Integer                          $operation_id    Identificador único de la operación
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList($perPage = 10, $page = 1, $operation = null, $operation_id = null)
    {
        $user_profile = Profile::where('user_id', auth()->user()->id)->first();
        $institution_id = isset($user_profile->institution_id)
            ? $user_profile->institution_id
            : null;

        if ($operation == null) {
            if (Auth()->user()->isAdmin()) {
                $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id');
            } else {
                $assets = Asset::where('institution_id', $institution_id)
                ->with([
                    'institution',
                    'assetCondition',
                    'assetStatus'
                ])->orderBy('id');
            }
        } elseif ($operation_id == null) {
            if ($operation == 'asignations') {
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('asset_condition_id', 1)->where('asset_status_id', 10);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('institution_id', $institution_id)
                        ->where('asset_condition_id', 1)->where('asset_status_id', 10);
                }
            } elseif ($operation == 'disincorporations') {
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('asset_status_id', 10);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('institution_id', $institution_id)
                        ->where('asset_status_id', 10);
                }
            } elseif ($operation == 'requests') {
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('asset_status_id', 10);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->where('institution_id', $institution_id)
                        ->where('asset_status_id', 10);
                }
            }
        } else {
            if ($operation == 'asignations') {
                $selected = [];
                $assetAsignationAssets = AssetAsignation::find($operation_id)->assetAsignationAssets()->get();
                foreach ($assetAsignationAssets as $assetAsignationAsset) {
                    array_push($selected, $assetAsignationAsset->asset_id);
                }
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10)
                        ->where('asset_condition_id', 1);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10)
                        ->where('asset_condition_id', 1)
                        ->where('institution_id', $institution_id);
                }
            } elseif ($operation == 'disincorporations') {
                $selected = [];
                $assetDisincorporationAssets = AssetDisincorporation::find($operation_id)
                    ->assetDisincorporationAssets()->get();
                foreach ($assetDisincorporationAssets as $assetDisincorporationAsset) {
                    array_push($selected, $assetDisincorporationAsset->asset_id);
                }
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10)
                        ->where('institution_id', $institution_id);
                }
            } elseif ($operation == 'requests') {
                $selected = [];
                $assetRequestAssets = AssetRequest::find($operation_id)->assetRequestAssets()->get();
                foreach ($assetRequestAssets as $assetRequestAsset) {
                    array_push($selected, $assetRequestAsset->asset_id);
                }
                if (Auth()->user()->isAdmin()) {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10);
                } else {
                    $assets = Asset::with('institution', 'assetCondition', 'assetStatus')->orderBy('id')
                        ->whereIn('id', $selected)
                        ->orWhere('asset_status_id', 10)
                        ->where('institution_id', $institution_id);
                }
            }
        }
        $total = $assets->count();
        $assets = $assets->offset(($page - 1) * $perPage)->limit($perPage)->get();
        $lastPage = max((int) ceil($total / $perPage), 1);
        return response()->json(
            [
                'records'  => $assets,
                'total'    => $total,
                'lastPage' => $lastPage,
            ],
            200
        );
    }

    /**
     * Filtra por su código de clasificación los bienes registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function searchClasification(Request $request)
    {
        $assets = Asset::CodeClasification(
            $request->asset_type,
            $request->asset_category,
            $request->asset_subcategory,
            $request->asset_specific_category
        )->with('institution', 'assetCondition', 'assetStatus');
        if ($request->asset_status > 0) {
            $assets = $assets->where('asset_status_id', $request->asset_status);
        }

        return response()->json(['records' => $assets->get()], 200);
    }

    /**
     * Filtra por su fecha de registro los bienes registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function searchGeneral(Request $request)
    {
        $assets = Asset::DateClasification($request->start_date, $request->end_date, $request->mes_id, $request->year)
            ->with('institution', 'assetCondition', 'assetStatus');
        if ($request->asset_status > 0) {
            $assets = $assets->where('asset_status_id', $request->asset_status);
        }

        return response()->json(['records' => $assets->get()], 200);
    }

    /**
     * Filtra por su ubicación en la institución los bienes registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function searchDependence(Request $request)
    {
        /*
         *  Falta filtrar por dependencia solicitante
         *  Validar tambien para múltiples instituciones
         *
         */
        //Asset::with('assetCondition','assetStatus')->get();
        return response()->json(['records' => []], 200);
    }

    /**
     * Realiza la acción necesaria para exportar los datos del modelo Asset
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    object    Objeto que permite descargar el archivo con la información a ser exportada
     */
    public function export()
    {
        return Excel::download(new AssetExport, 'assets.xlsx');
    }

    /**
     * Realiza la acción necesaria para importar los datos suministrados en un archivo para el modelo Asset
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    object    Objeto que permite descargar el archivo con la información a ser exportada
     */
    public function import(Request $request)
    {
        Excel::import(new AssetImport, request()->file('file'));
        return response()->json(['result' => true], 200);
    }
}
