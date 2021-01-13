<?php

/** Revisar */
namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Asset\Models\Asset;
use Modules\Asset\Models\AssetAsignation;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\AssetRequest;

/**
 * @class      AssetDashboardController
 * @brief      Controlador del panel de control módulo de bienes
 *
 * Clase que gestiona las peticiones realizadas desde el panel de control del módulo de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetDashboardController extends Controller
{
    /**
     * Muestra la sección del dashboard del módulo de bienes
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function index()
    {
        return view('asset::dashboard');
    }

    /**
     * Otiene un listado de las existencias en inventario de los bienes registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     String                           $type     Tipo de solicitud
     * @param     String                           $order    Orden en el que se expresan los registros
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function getInventoryAssets($type, $order = 'desc')
    {
        $fields = [];
        if ($type == 'exist') {
            $fields = Asset::with('assetSpecificCategory')
                ->select('asset_specific_category_id', \DB::raw('count(*) as total'))
                ->groupBy('asset_specific_category_id');
            $fields = ($order == 'desc')?$fields->orderBy('total', 'desc')->get():
                $fields->orderBy('total', 'asc')->get();
        } else {
            $fields = \DB::table('asset_request_assets')
                ->leftJoin('assets', 'asset_request_assets.asset_id', '=', 'assets.id')
                ->leftJoin(
                    'asset_specific_categories',
                    'assets.asset_specific_category_id',
                    '=',
                    'asset_specific_categories.id'
                )
                ->select(
                    'asset_specific_categories.id',
                    'asset_specific_categories.name as name',
                    \DB::raw('count(*) as total')
                )
                ->groupBy('asset_specific_categories.id');

            $fields = ($order == 'desc')?$fields->orderBy('total', 'desc')->get():
                $fields->orderBy('total', 'asc')->get();
        }
        return response()->json(['records' => $fields]);
    }

    /**
     * Obtiene la url de la operación a mostrar
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     String                           $type_operation    Tipo de operación a mostrar
     * @param     String                           $code              Identificador único de la operación
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function getOperation($type_operation, $code)
    {
        if ($type_operation == 'registers') {
            return response()->json(['result' => true, 'redirect' => '/asset/reports/show/' . $code], 200);
        } else {
            return response()->json(['result' => true, 'redirect' => '/asset/reports/show/' . $code], 200);
        }
    }

    /**
     * Otiene un listado de las operaciones registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueListOperations()
    {
        $tables = ['assets', 'asset_asignations', 'asset_disincorporations', 'asset_requests'];
        $fields = [];

        foreach ($tables as $table) {
            if ($table == 'assets') {
                $type_operation = 'registers';
                $description = 'Registro manual de bienes institucionales';
                $data_operations = \DB::table($table)
                    ->select('created_at', \DB::raw('count(*) as total'))
                    ->groupBy('created_at')
                    ->get();
                foreach ($data_operations as $data) {
                    array_push($fields, [
                        'code' => $data->created_at,
                        'type_operation' => $type_operation,
                        'description' => $description,
                        'created_at' => $data->created_at,
                        'total_assets' => $data->total,
                    ]);
                }
            } else {
                if ($table == 'asset_asignations') {
                    $type_operation = 'asignations';
                    $description = 'Asignación de bienes institucionales';
                } elseif ($table == 'asset_disincorporations') {
                    $type_operation = 'disincorporations';
                    $description = 'Desincorporación de bienes institucionales';
                } elseif ($table == 'asset_requests') {
                    $type_operation = 'requests';
                    $description = 'Solicitud de bienes institucionales';
                }
                $data_operations = \DB::table($table)
                     ->select('code', 'created_at')
                     ->get();
                foreach ($data_operations as $data) {
                    array_push($fields, [
                        'code' => $data->code,
                        'type_operation' => $type_operation,
                        'description' => $description,
                        'created_at' => $data->created_at,
                    ]);
                }
            }
        }
        return response()->json(['records' => $fields]);
    }

    /**
     * Obtiene la información de una operación registrada
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     String                           $type_operation    Tipo de operación a mostrar
     * @param     String                           $filter            Identificador único de la operación
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($type_operation, $filter)
    {
        if ($type_operation == 'registers') {
            $assets = Asset::where('created_at', $filter)->get();
            return response()->json(['records' => $assets], 200);
        } elseif ($type_operation == 'asignations') {
            $field = AssetAsignation::where('code', $filter)
                ->with(['assetAsignationAssets' => function ($query) {
                    $query->with('asset');
                }])->first();
            return response()->json(['records' => $field->assetAsignationAssets], 200);
        } elseif ($type_operation == 'disincorporations') {
            $field = AssetDisincorporation::where('code', $filter)
                ->with(['assetDisincorporationAssets' => function ($query) {
                    $query->with('asset');
                }])->first();
            return response()->json(['records' => $field->assetDisincorporationAssets], 200);
        } elseif ($type_operation == 'requests') {
            $field = AssetRequest::where('code', $filter)
                ->with(['assetRequestAssets' => function ($query) {
                    $query->with('asset');
                }])->first();
            return response()->json(['records' => $field->assetRequestAssets], 200);
        }
    }
}
