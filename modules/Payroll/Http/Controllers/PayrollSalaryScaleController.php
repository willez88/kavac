<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSalaryScale;
use Modules\Payroll\Models\PayrollScale;

use Modules\Payroll\Models\PayrollPosition;
use Modules\Payroll\Models\PayrollInstructionDegree;
use App\Models\Institution;
use App\Models\CodeSetting;

/**
 * @class      PayrollSalaryScaleController
 * @brief      Controlador de los escalafones salariales
 *
 * Clase que gestiona los escalafones salariales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollSalaryScaleController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     *
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     *
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.setting.salary-scale');

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'           => ['required'],
            'institution_id' => ['required'],
            'payroll_scales' => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'institution_id.required' => 'El campo institución es obligatorio.',
            'payroll_scales.required' => 'Debe registrar al menos una escala o nivel.'
        ];
    }
    
    /**
     * Muestra un listado de los escalafones salariales registrados
     *
     * @method    index
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryScale::with('payrollScales')->get()], 200);
    }

    /**
     * Valida y registra un nuevo escalafón salarial
     *
     * @method    store
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        $codeSetting = CodeSetting::where('table', 'payroll_salary_scales')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('payroll.setting.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        
        DB::transaction(function () use ($request, $code) {
            $salaryScale = PayrollSalaryScale::create([
                'code'                   => $code,
                'name'                   => $request->input('name'),
                'active'                 => !empty($request->input('active'))
                                                ? $request->input('active')
                                                : false,
                'description'            => $request->input('description'),
                'institution_id'         => $request->input('institution_id'),
                'group_by'               => $request->input('group_by')
            ]);
            foreach ($request->payroll_scales as $payrollScale) {
                $scale = PayrollScale::create([
                    'name'                    => $payrollScale['name'],
                    'value'                   => json_encode($payrollScale['value']),
                    'payroll_salary_scale_id' => $salaryScale->id,
                ]);
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Actualiza la información del escalafón salarial
     *
     * @method    update
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id         Identificador único asociado al escalafón salarial
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $payrollSalaryScale = PayrollSalaryScale::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        DB::transaction(function () use ($request, $payrollSalaryScale) {
            $payrollSalaryScale->name                   = $request->input('name');
            $payrollSalaryScale->description            = $request->input('description');
            $payrollSalaryScale->institution_id         = $request->input('institution_id');
            $payrollSalaryScale->active                 = !empty($request->input('active'))
                                                              ? $request->input('active')
                                                              : $payrollSalaryScale->active;
            $payrollSalaryScale->group_by               = $request->input('group_by');

            $payrollSalaryScale->save();
            $updated_at = now();

            /** Se agregan los nuevos niveles o escalas y se actualizan los existentes */
            foreach ($request->payroll_scales as $payrollScale) {
                if ($payrollScale['id'] > 0) {
                    $scale              = PayrollScale::find($payrollScale['id']);
                    $scale->name        = $payrollScale['name'];
                    $scale->value       = json_encode($payrollScale['value']);
                    $scale->updated_at  = $updated_at;
                    $scale->save();
                } else {
                    $scale = PayrollScale::Create([
                        'name'                    => $payrollScale['name'],
                        'value'                   => json_encode($payrollScale['value']),
                        'payroll_salary_scale_id' => $payrollSalaryScale->id,
                        'updated_at'              => $updated_at,
                    ]);
                }
            }

            /** Se eliminan los demas niveles o escalas del escalafón salarial */
            $payrollScales = PayrollScale::where('payroll_salary_scale_id', $payrollSalaryScale->id)->get();

            foreach ($payrollScales as $payrollScale) {
                if ($payrollScale->updated_at->format('Y-m-d H:i:s') != $updated_at->format('Y-m-d H:i:s')) {
                    $payrollScale->delete();
                }
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Elimina un escalafón salarial
     *
     * @method    destroy
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Payroll\Models\PayrollSalaryScale    $salaryScale    Datos del escalafón salarial
     * @return    \Illuminate\Http\JsonResponse                 Objeto con los registros a mostrar
     */
    public function destroy(PayrollSalaryScale $salaryScale)
    {
        $salaryScale->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene el listado de los escalafones salariales a implementar en elementos select
     *
     * @method    getSalaryScales
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Listado de los registros a mostrar
     */
    public function getSalaryScales(Request $request)
    {
        /**Falta incluir el except_id en templatechoices */
        $institution  = $request->institution_id ?? Institution::where([
            'default' => true,
            'active'  => true
        ])->first();
        return template_choices(
            'Modules\Payroll\Models\PayrollSalaryScale',
            'name',
            [
                'institution_id'         => $request->institution_id ?? $institution->id
            ],
            true
        );
    }

    /**
     * Obtiene la información de un escalafón salarial
     *
     * @method    info
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id    Identificador único sociado al escalafón salarial
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function info($id)
    {
        return response()->json(['record' => PayrollSalaryScale::where('id', $id)
            ->with('payrollScales')->first()], 200);
    }
}
