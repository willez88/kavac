<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\CodeSetting;

use Modules\Asset\Models\AssetInventoryAsset;
use Modules\Asset\Models\AssetInventory;
use Modules\Asset\Models\Asset;

/**
 * @class      AssetInventoryController
 * @brief      Controlador del historico de inventario de bienes institucionales
 *
 * Clase que gestiona el historico del inventario de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetInventoryController extends Controller
{
    /**
     * Muestra un listado de los inventarios registrados
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\View\View
     */
    public function index()
    {
        return view('asset::inventories.list');
    }

    /**
     * Valida y registra el estado actual del inventario
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $codeSetting = CodeSetting::where('table', 'asset_inventories')->first();
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
         * Objeto asociado al modelo AssetInventory
         *
         * @var Object $inventory
         */
        $inventory = AssetInventory::create([
            'code' => $code,
        ]);
        $assets = Asset::with('assetCondition', 'assetStatus', 'assetUseFunction')->withTrashed()->get();

        $registered = count($assets);
        $assigned = $disincorporated = $reserved = 0;

        foreach ($assets as $asset) {
            if ($asset->status_id = 1) {
                $assigned += $assigned;
            } elseif ($asset->status_id = 6) {
                $reserved += $reserved;
            } elseif (in_array($asset->status_id, [5,7,8,9])) {
                $disincorporated += $disincorporated;
            }

            $inventory_asset = AssetInventoryAsset::create([
                'asset_condition'    => ($asset->assetCondition)?$asset->assetCondition->name:null,
                'asset_status'       => ($asset->assetStatus)?$asset->assetStatus->name:null,
                'asset_use_function' => ($asset->assetUseFunction)?$asset->assetUseFunction->name:null,
                'asset_id'           => $asset->id,
                'asset_inventory_id' => $inventory->id,
            ]);
        }
        $inventory->registered      = $registered;
        $inventory->assigned        = $assigned;
        $inventory->disincorporated = $disincorporated;
        $inventory->reserved        = $reserved;
        $inventory->save();

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.inventory-history.index')], 200);
    }

    /**
     * Elimina un registro de inventario
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                                 $id    Identificador único del registro a eliminar
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        $inventory = AssetInventory::find($id);
        $inventory->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Otiene un listado de las inventarios registradas
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList()
    {
        return response()->json(['records' => AssetInventory::with('assetInventoryAssets')->get()], 200);
    }
}
