<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\BudgetModification;

/**
 * @class BudgetSettingController
 * @brief Controlador de configuraciones en el módulo de Presupuesto
 * 
 * Clase que gestiona las configuraciones en el módulo de Presupuesto
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetSettingController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.setting.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.setting.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.setting.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.setting.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function index()
    {
        /** @var object Contiene los registros de proyectos */
        $projects = BudgetProject::all();
        /** @var object Contiene los registros de configuraciones de códigos */
        $codeSettings = CodeSetting::where('module', 'budget')->get();
        /** @var object Contiene información sobre la configuración de código para la formulación */
        $fCode = $codeSettings->where('table', 'budget_formulations')->first();
        /** @var object Contiene información sobre la configuración de código para los compromisos */
        $cCode = $codeSettings->where('table', 'budget_commitments')->first();
        /** @var object Contiene información sobre la configuración de código para los créditos adicionales */
        $crCode = $codeSettings->where('table', 'budget_modifications')->where('type', 'budget.aditional-credits')->first();
        /** @var object Contiene información sobre la configuración de código para las reducciones presupuestarias */
        $rCode = $codeSettings->where('table', 'budget_modifications')->where('type', 'budget.reductions')->first();
        /** @var object Contiene información sobre la configuración de código para las transferencias entre presupuestos */
        $tCode = $codeSettings->where('table', 'budget_modifications')->where('type', 'budget.transfers')->first();
        /** @var object Contiene información sobre la configuración de código para los causados presupuestarios */
        $caCode = $codeSettings->where('table', 'budget_caused')->first();
        /** @var object Contiene información sobre la configuración de código para los pagados presupuestarios */
        $pCode = $codeSettings->where('table', 'budget_payed')->first();
        
        return view('budget::settings', compact(
            'projects', 'fCode', 'cCode', 'tCode', 'rCode', 'crCode', 'caCode', 'pCode'
        ));
    }

    /**
     * Muestra un formulario para la creación de las configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function create()
    {
        //return view('budget::create');
    }

    /**
     * Guarda información de las configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $request->validate([
            'formulations_code' => [new CodeSettingRule],
            'commitments_code' => [new CodeSettingRule],
            'caused_code' => [new CodeSettingRule],
            'payed_code' => [new CodeSettingRule],
            'transfers_code' => [new CodeSettingRule],
            'reductions_code' => [new CodeSettingRule],
            'credits_code' => [new CodeSettingRule],
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
                
                if ($table === "formulations") {
                    /** @var string Define el modelo para asociado a la formulación de presupuesto */
                    $model = BudgetSubSpecificFormulation::class;
                }
                else if (in_array($key, ['transfers_code', 'reductions_code', 'credits_code'])) {
                    /** @var string Define el modelo asociado a las modificaciones presupuestarias */
                    $model = BudgetModification::class;
                    /** @var string Define la tabla asociada a las modificaciones presupuestarias */
                    $table = 'modifications';
                    if ($key === 'transfers_code') {
                        /** @var string Define el tipo de registro como transferencia entre presupuestos */
                        $type = 'budget.transfers';
                    }
                    else if ($key === 'reductions_code') {
                        /** @var string Define el tipo de registro como reducciones presupuestarias */
                        $type = 'budget.reductions';
                    }
                    else if ($key === 'credits_code') {
                        /** @var string Define el tipo de registro como créditos adicionales */
                        $type = 'budget.aditional-credits';
                    }
                }
                else if ($table === "commitments") {
                    $model .= "Commitment";
                }

                CodeSetting::updateOrCreate([
                    'module' => 'budget',
                    'table' => 'budget_' . $table,
                    'field' => $field,
                    'type' => (isset($type)) ? $type : null
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

    /**
     * Muestra información con las configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function show()
    {
        //return view('budget::show');
    }

    /**
     * Muestra el formulario para editar información de configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function edit()
    {
        //return view('budget::edit');
    }

    /**
     * Actualiza información de configuración de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Elimina configuraciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function destroy()
    {
    }
}
