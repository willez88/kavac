<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Modules\Payroll\Rules\PayrollSalaryScales;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Payroll\Exports\PayrollSalaryTabulatorExport;

use Modules\Payroll\Models\PayrollSalaryTabulatorScale;
use Modules\Payroll\Models\PayrollSalaryTabulator;
use Modules\Payroll\Models\PayrollStaffType;
use App\Models\CodeSetting;

/**
 * @class      PayrollSalaryTabulatorController
 * @brief      Controlador de los tabuladores salariales
 *
 * Clase que gestiona los tabuladores salariales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollSalaryTabulatorController extends Controller
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
        //$this->middleware('permission:payroll.setting.salary-tabulator');

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'                            => ['required'],
            'currency_id'                     => ['required'],
            'payroll_staff_types'             => ['required'],
            'institution_id'                  => ['required'],
            'payroll_salary_tabulator_type'   => ['required'],
            'payroll_salary_tabulator_scales' => ['required', new PayrollSalaryScales()]
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'currency_id.required'        => 'El campo moneda es obligatorio.',
            'payroll_staff_types.required' => 'El campo tipo de personal es obligatorio.',
            'institution_id.required'          => 'El campo institución es obligatorio.',
            'payroll_salary_tabulator_type.required'   => 'El campo tipo de tabulador es obligatorio.'
        ];
    }
    
    /**
     * Muestra un listado de los tabuladores salariales registrados
     *
     * @method    index
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        $payrollSalaryTabulators = PayrollSalaryTabulator::with([
            'payrollVerticalSalaryScale' => function ($query) {
                $query->with('payrollScales')->get();
            },
            'payrollHorizontalSalaryScale' => function ($query) {
                $query->with('payrollScales')->get();
            },
            'payrollSalaryTabulatorScales'
        ])->get();
        foreach ($payrollSalaryTabulators as $payrollSalaryTabulator) {
            $payrollStaffTypes = [];
            if ($payrollSalaryTabulator->payrollStaffTypes) {
                foreach ($payrollSalaryTabulator->payrollStaffTypes as $payrollStaffType) {
                    $payrollStaffType['text'] = $payrollStaffType['name'];
                    
                }
            }
        }
        return response()->json(['records' => $payrollSalaryTabulators], 200);
    }

    /**
     * Valida y registra un nuevo tabulador salarial
     *
     * @method    store
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        $codeSetting = CodeSetting::where('table', 'payroll_salary_tabulators')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('payroll.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        
        DB::transaction(function () use ($request, $code) {
            /**
             * Objeto asociado al modelo PayrollSalaryTabulator
             *
             * @var Object $salaryTabulator
             */
            $salaryTabulator = PayrollSalaryTabulator::create([
                'code'                               => $code,
                'name'                               => $request->input('name'),
                'active'                             => !empty($request->input('active'))
                                                        ? $request->input('active')
                                                        : false,
                'description'                        => $request->input('description'),
                'institution_id'                     => $request->input('institution_id'),
                'currency_id'                        => $request->input('currency_id'),
                'payroll_salary_tabulator_type'      => $request->input('payroll_salary_tabulator_type'),
                'payroll_vertical_salary_scale_id'   => $request->input('payroll_vertical_salary_scale_id'),
                'payroll_horizontal_salary_scale_id' => $request->input('payroll_horizontal_salary_scale_id')
            ]);

            if ($salaryTabulator) {
                /** Se agregan los registros de tipos de personal a la tabla intermedia */
                foreach ($request->payroll_staff_types as $payroll_staff_type) {
                    $staff_type_id = PayrollStaffType::find($payroll_staff_type['id']);
                    $salaryTabulator->payrollStaffTypes()->attach($staff_type_id);
                }
                /** Se agregan las escalas del tabulador salarial */
                foreach ($request->payroll_salary_tabulator_scales as $payrollScale) {
                    /**
                     * Objeto asociado al modelo PayrollSalaryTabulatorScale
                     *
                     * @var Object $salaryTabulatorScale
                     */
                    $salaryTabulatorScale = PayrollSalaryTabulatorScale::create([
                        'value'                       => $payrollScale['value'],
                        'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'] ?? null,
                        'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'] ?? null,
                        'payroll_salary_tabulator_id' => $salaryTabulator->id
                    ]);
                }
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Actualiza la información del tabulador salarial
     *
     * @method    update
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id         Identificador único asociado al tabulador salarial
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $salaryTabulator = PayrollSalaryTabulator::where('id', $id)->first();
        $this->validate($request, $this->validateRules, $this->messages);

        DB::transaction(function () use ($request, $salaryTabulator) {
            $salaryTabulator->update([
                'name'                               => $request->input('name'),
                'active'                             => !empty($request->input('active'))
                                                        ? $request->input('active')
                                                        : $salaryTabulator->active,
                'description'                        => $request->input('description'),
                'institution_id'                     => $request->input('institution_id'),
                'currency_id'                        => $request->input('currency_id'),
                'payroll_salary_tabulator_type'      => $request->input('payroll_salary_tabulator_type'),
                'payroll_vertical_salary_scale_id'   => $request->input('payroll_vertical_salary_scale_id'),
                'payroll_horizontal_salary_scale_id' => $request->input('payroll_horizontal_salary_scale_id')
            ]);

            /** Se eliminan los registros en desuso de tipos de personal de la tabla intermedia */
            foreach ($salaryTabulator->payrollStaffTypes() as $payrollStaffType) {
                $staffType_id = PayrollStaffType::find($payrollStaffType['id']);
                $salaryTabulator->payrollStaffTypes()->detach($staffType_id);
            }
            /** Se agregan los nuevos registros de tipos de personal a la tabla intermedia */
            foreach ($request->payroll_staff_types as $payrollStaffType) {
                $staffType_id = PayrollStaffType::find($payrollStaffType['id']);
                $salaryTabulator->payrollStaffTypes()->attach($staffType_id);
            }

            /**
             * Fecha en la que fue actualizado el registro
             * @var date $updated_at
             */
            $updated_at = now();
            /**
             * Objeto del registro de la escala asociada al tabulador salarial
             * @var Object $salaryTabulatorScale
             */
            $salaryTabulatorScale = null;

            /**
             * Identificador único del registro del escalafón salarial horizontal
             * @var integer $oldHorizontalScale
             */
            $oldHorizontalScale =
                ($request->payroll_horizontal_salary_scale_id == $salaryTabulator->payroll_horizontal_salary_scale_id)
                    ? null
                    : $salaryTabulator->payroll_horizontal_salary_scale_id;
            /**
             * Identificador único del registro del escalafón salarial vertical
             * @var integer $oldHorizontalScale
             */
            $oldVerticalScale =
                ($request->payroll_vertical_salary_scale_id == $salaryTabulator->payroll_vertical_salary_scale_id)
                    ? null
                    : $salaryTabulator->payroll_vertical_salary_scale_id;

            /** Se actualizan las escalas asociadas al tabulador */
            foreach ($request->payroll_salary_tabulator_scales as $payrollScale) {
                if (is_null($oldVerticalScale) && !is_null($oldHorizontalScale)) {
                    $salaryTabulatorScale = PayrollSalaryTabulatorScale::where([
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'],
                    ])->first();
                    if ($salaryTabulatorScale) {
                        $salaryTabulatorScale->value                       = $payrollScale['value'];
                        $salaryTabulatorScale->updated_at                  = $updated_at;
                        $salaryTabulatorScale->payroll_horizontal_scale_id =
                            $payrollScale['payroll_horizontal_scale_id'];
                        $salaryTabulatorScale->save();
                    }
                } elseif (!is_null($oldVerticalScale) && is_null($oldHorizontalScale)) {
                    $salaryTabulatorScale = PayrollSalaryTabulatorScale::where([
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'],
                    ])->first();
                    if ($salaryTabulatorScale) {
                        $salaryTabulatorScale->value                     = $payrollScale['value'];
                        $salaryTabulatorScale->updated_at                = $updated_at;
                        $salaryTabulatorScale->payroll_vertical_scale_id = $payrollScale['payroll_vertical_scale_id'];
                        $salaryTabulatorScale->save();
                    }
                } elseif (is_null($oldVerticalScale) && is_null($oldHorizontalScale)) {
                    $salaryTabulatorScale = PayrollSalaryTabulatorScale::where([
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'] ?? null,
                        'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'] ?? null,
                    ])->orWhere([
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'payroll_vertical_scale_id'   => null,
                        'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'] ?? null,
                    ])->orWhere([
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'] ?? null,
                        'payroll_horizontal_scale_id' => null,
                    ])->first();

                    $salaryTabulatorScale->payroll_horizontal_scale_id = $payrollScale['payroll_horizontal_scale_id'] ?? null;
                    $salaryTabulatorScale->payroll_vertical_scale_id   = $payrollScale['payroll_vertical_scale_id'] ?? null;
                    $salaryTabulatorScale->value                       = $payrollScale['value'];
                    $salaryTabulatorScale->updated_at                  = $updated_at;
                    $salaryTabulatorScale->save();
                }
                if (is_null($salaryTabulatorScale)) {
                    $salaryTabulatorScale = PayrollSalaryTabulatorScale::create([
                        'value'                       => $payrollScale['value'],
                        'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'] ?? null,
                        'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'] ?? null,
                        'payroll_salary_tabulator_id' => $salaryTabulator->id,
                        'updated_at'                  => $updated_at
                    ]);
                }
            }
            /** Se eliminan las demas escalas asociadas al tabulador */
            $payrollSalaryTabulatorScales = PayrollSalaryTabulatorScale::where([
                'payroll_salary_tabulator_id' => $salaryTabulator->id,
            ])->get();
            foreach ($payrollSalaryTabulatorScales as $payrollSalaryTabulatorScale) {
                if ($payrollSalaryTabulatorScale->updated_at->format('Y-m-d H:i:s')
                    != $updated_at->format('Y-m-d H:i:s')) {
                    $payrollSalaryTabulatorScale->delete();
                }
            }
        });
    }

    /**
     * Elimina un tabulador salarial
     *
     * @method    destroy
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Payroll\Models\PayrollSalaryTabulator    $salaryTabulator    Datos del tabulador salarial
     * @return    \Illuminate\Http\JsonResponse                     Objeto con los registros a mostrar
     */
    public function destroy(PayrollSalaryTabulator $salaryTabulator)
    {
        $salaryTabulator->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene el listado de los tabuladores salariales registrados a implementar en elementos select
     *
     * @method    getSalaryTabulators
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Listado de registros a mostrar
     */
    public function getSalaryTabulators()
    {
        return template_choices('Modules\Payroll\Models\PayrollSalaryTabulator', 'name', '', true);
    }

    /**
     * Exporta un tabulador salarial
     *
     * @method    export
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                       $id    Identificador único asociado al tabulador salarial
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function export($id)
    {
        $payrollSalaryTabulator = PayrollSalaryTabulator::where('id', $id)->first();
        if ($payrollSalaryTabulator) {
            $export = new PayrollSalaryTabulatorExport(PayrollSalaryTabulator::class);
            $export->setSalaryTabulatorId($payrollSalaryTabulator->id);
            return Excel::download($export, 'salary_tabulator'. $payrollSalaryTabulator->created_at . '.xlsx');
        }
    }
}
