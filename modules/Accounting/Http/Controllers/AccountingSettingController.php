<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;
use Auth;

/**
 * @class AccountingConfigurationCategoryController
 * @brief Controlador de categorias de origen para sientos contables
 *
 * Clase que gestiona las categorias para asientos contables
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingSettingController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.setting.index', ['only' => 'index']);
    }

    /**
     * Muestra la vista la configuración del modulo
     * @return view
     */
    public function index()
    {
        $codeSettings = CodeSetting::where('module', 'accounting')->get();
        $refCode = $codeSettings->where('table', 'accounting_seats')->first();
        return view('accounting::setting.index', compact('refCode'));
    }

    public function code_store(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $this->validate($request, [
            'seats_reference' => [new CodeSettingRule]
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
                
                /**
                 * [$model define el modelo asociado a asientos contables]
                 * @var string
                 */
                $model = \Modules\Accounting\Models\AccountingSeat::class;

                CodeSetting::updateOrCreate([
                    'module' => 'accounting',
                    'table' => 'accounting_'. $table,
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

    public function generate_reference_code(Request $request)
    {
        $codeSetting = CodeSetting::where('table', 'accounting_seats')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            // return response()->json(['result' => false, 'redirect' => route('asset.settings.index')], 200);
            return "DEBE configurar";
        }

        $code  = generate_registration_code(
            $request['format_prefix'],
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        return response()->json(['code'=>$code], 200);
    }
}
