<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingEntry;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

/**
 * @class AccountingConfigurationCategoryController
 * @brief Controlador de las configuracion de codigo del modulo
 *
 * Clase que gestiona las configuracion de codigo del modulo
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
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
     * @return Renderable
     */
    public function index()
    {
        $institution  = get_institution();
        $codeSettings = CodeSetting::where('module', 'accounting')->get();
        $refCode      = $codeSettings->where('table', 'accounting_entries')
                                ->first();
        return view('accounting::settings.index', compact('refCode'));
    }

    public function codeStore(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $this->validate($request, [
            'entries_reference' => [new CodeSettingRule]
        ]);

        $institution = get_institution();

        /**
         * [$codes información de los campos de códigos configurados]
         * @var string
         */
        $codes = $request->input();
        /**
         * [$saved Define el estatus verdadero para indicar que no se ha registrado información]
         * @var boolean
         */
        $saved = false;

        foreach ($codes as $key => $value) {
            /**
             * [$model Define el modelo al cual hace referencia el código]
             * @var string
             */
            $model = '';

            if ($key !== '_token' && !is_null($value)) {
                list($table, $field) = explode("_", $key);
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);

                /**
                 * [$model define el modelo asociado a asientos contables]
                 * @var string
                 */
                $model = AccountingEntry::class;
                CodeSetting::updateOrCreate([
                    'module' => 'accounting',
                    'table'  => 'accounting_'. $table,
                    'field'  => $field,
                ], [
                    'format_prefix' => strtoupper($prefix),
                    'format_digits' => $digits,
                    'format_year'   => strtoupper($sufix),
                    'model'         => $model,
                ]);

                /**
                 * [$saved Define el estatus verdadero para indicar que se ha registrado información]
                 * @var boolean
                 */
                $saved = true;
            }
        }

        if ($saved) {
            $request->session()->flash('message', ['type' => 'store']);
        }

        return redirect()->back();
    }

    public function generateReferenceCode(Request $request)
    {
        $institution = get_institution();
        $codeSetting = CodeSetting::where('table', 'accounting_entries')
        ->first();
        if (is_null($codeSetting)) {
            $code = AccountingEntry::count();
            $request->session()->flash('message', [
                'type'  => 'other',
                'title' => 'Alerta',
                'icon'  => 'screen-error',
                'class' => 'growl-danger',
                'text'  => 'Se debe configurar previamente el formato para el código de referencia del asiento.
                De lo contrario el sistema les asignara números de forma progresiva'
            ]);
        } else {
            $code  = generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                AccountingEntry::class,
                $codeSetting->field
            );
        }

        return response()->json(['code'=>$code], 200);
    }
}
