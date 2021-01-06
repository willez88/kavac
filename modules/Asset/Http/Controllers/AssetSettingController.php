<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

/**
 * @class      AssetSettingController
 * @brief      Controlador del panel de configuración del módulo de bienes
 *
 * Clase que gestiona la configuración general del módulo de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetSettingController extends Controller
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
        $this->middleware('permission:asset.setting', ['only' => 'index']);
    }

    /**
     * Muestra la configuración del módulo de bienes
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function index()
    {
        $codeSettings = CodeSetting::where('module', 'asset')->get();
        $asCode = $codeSettings->where('table', 'asset_asignations')->first();
        $dsCode = $codeSettings->where('table', 'asset_disincorporations')->first();
        $rqCode = $codeSettings->where('table', 'asset_requests')->first();
        $rpCode = $codeSettings->where('table', 'asset_reports')->first();
        $ivCode = $codeSettings->where('table', 'asset_inventories')->first();
        return view('asset::settings', compact('codeSettings', 'asCode', 'dsCode', 'rqCode', 'rpCode', 'ivCode'));
    }

    /**
     * Valida y registra la configuración de códigos del módulo de bienes
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    Renderable
     */
    public function store(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $this->validate($request, [
            'asignations_code' => [new CodeSettingRule],
            'disincorporations_code' => [new CodeSettingRule],
            'requests_code' => [new CodeSettingRule],
            'reports_code' => [new CodeSettingRule],
            'inventories_code' => [new CodeSettingRule]
        ]);

        /** @var array Arreglo con información de los campos de códigos configurados */
        $codes = $request->input();
        /** @var boolean Define el estatus verdadero para indicar que no se ha registrado información */
        $saved = false;

        foreach ($codes as $key => $value) {
            /** @var string Define el modelo al cual hace referencia el código */
            $model = '';

            if ($key !== '_token' && !is_null($value)) {
                list($table, $field) = explode("_", $key);
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);

                if ($table === "asignations") {
                    /** @var string Define el modelo para asociado a las asignaciones de bienes */
                    $model = \Modules\Asset\Models\AssetAsignation::class;
                } elseif ($table === "disincorporations") {
                    /** @var string Define el modelo para asociado a las desincorporaciones de bienes */
                    $model = \Modules\Asset\Models\AssetDisincorporation::class;
                } elseif ($table === "requests") {
                    /** @var string Define el modelo para asociado a las solicitudes de bienes */
                    $model = \Modules\Asset\Models\AssetRequest::class;
                } elseif ($table === "reports") {
                    /** @var string Define el modelo para asociado a los reportes de bienes */
                    $model = \Modules\Asset\Models\AssetReport::class;
                } elseif ($table === "inventories") {
                    /** @var string Define el modelo para asociado al inventario de bienes */
                    $model = \Modules\Asset\Models\AssetInventory::class;
                }

                CodeSetting::updateOrCreate([
                    'module' => 'asset',
                    'table' => 'asset_'. $table,
                    'field' => $field,
                ], [
                    'format_prefix' => $prefix,
                    'format_digits' => $digits,
                    'format_year' => $sufix,
                    'model' => $model,
                ]);

                /** @var boolean Define el estatus verdadero para indicar que se ha registrado información */
                $saved = true;
            }
        }

        if ($saved) {
            $request->session()->flash('message', ['type' => 'store']);
        }

        return redirect()->back();
    }
}
