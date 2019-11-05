<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSalaryTabulator;
use Modules\Payroll\Models\PayrollSalaryTabulatorScale;

/**
 * @class PayrollSalaryTabulatorController
 * @brief Controlador de los tabuladores salariales
 *
 * Clase que gestiona los tabuladores salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryTabulatorController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.setting.salary-tabulator');
    }
    
    /**
     * Muestra un listado de los tabuladores salariales registrados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryTabulator::with([
            'payrollStaffType',
            'payrollVerticalSalaryScale' => function ($query) {
                $query->with('payrollScales')->get();
            },
            'payrollHorizontalSalaryScale' => function ($query) {
                $query->with('payrollScales')->get();
            },
            'payrollSalaryTabulatorScales'
        ])->get()], 200);
    }

    /**
     * Valida y registra un nuevo tabulador salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request Datos de la petición
     * @return \Illuminate\Http\JsonResponse      Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code'                            => ['required'],
            'name'                            => ['required'],
            'description'                     => ['required'],
            'currency_id'                     => ['required'],
            //'institution_id'                  => ['required'],
            'payroll_salary_tabulator_scales' => ['required'],
            'payroll_staff_type_id'           => ['required'],
        ]);
        /**
         * Crear regla para validar las escalas (payroll_scales)
         */
        
        DB::transaction(function () use ($request) {
            $salaryTabulator = PayrollSalaryTabulator::create([
                'code'                               => $request->input('code'),
                'name'                               => $request->input('name'),
                'active'                             => !empty($request->input('active'))
                                                        ? $request->input('active')
                                                        : false,
                'description'                        => $request->input('description'),
                'institution_id'                     => $request->input('institution_id'),
                'currency_id'                        => $request->input('currency_id'),
                'payroll_staff_type_id'              => $request->input('payroll_staff_type_id'),
                'payroll_vertical_salary_scale_id'   => $request->input('payroll_vertical_salary_scale_id'),
                'payroll_horizontal_salary_scale_id' => $request->input('payroll_horizontal_salary_scale_id'),
            ]);

            foreach ($request->payroll_salary_tabulator_scales as $payrollScale) {
                $salaryTabulatorScale = PayrollSalaryTabulatorScale::create([
                    'value'                       => $payrollScale['value'],
                    'payroll_vertical_scale_id'   => $payrollScale['payroll_vertical_scale_id'] ?? null,
                    'payroll_horizontal_scale_id' => $payrollScale['payroll_horizontal_scale_id'] ?? null,
                    'payroll_salary_tabulator_id' => $salaryTabulator->id,
                ]);
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Actualiza la información del tabulador salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id                        Identificador único del registro asociado al tabulador salarial
     * @param  \Illuminate\Http\Request $request  Datos de la petición
     * @return \Illuminate\Http\JsonResponse      Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $salaryTabulator = PayrollSalaryTabulator::where('id', $id)->first();
        $this->validate($request, [
            'code'                            => ['required'],
            'name'                            => ['required'],
            'description'                     => ['required'],
            'currency_id'                     => ['required'],
            //'institution_id'                  => ['required'],
            'payroll_salary_tabulator_scales' => ['required'],
            'payroll_staff_type_id'           => ['required'],
        ]);

        /**
         * Crear regla para validar las escalas (payroll_scales)
         */
        DB::transaction(function () use ($request, $salaryTabulator) {
            $salaryTabulator->update([
                'code'                               => $request->input('code'),
                'name'                               => $request->input('name'),
                'active'                             => !empty($request->input('active'))
                                                        ? $request->input('active')
                                                        : $salaryTabulator->active,
                'description'                        => $request->input('description'),
                'institution_id'                     => $request->input('institution_id'),
                'currency_id'                        => $request->input('currency_id'),
                'payroll_staff_type_id'              => $request->input('payroll_staff_type_id'),
                'payroll_vertical_salary_scale_id'   => $request->input('payroll_vertical_salary_scale_id'),
                'payroll_horizontal_salary_scale_id' => $request->input('payroll_horizontal_salary_scale_id'),
            ]);

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
                    ])->first();

                    $salaryTabulatorScale->value      = $payrollScale['value'];
                    $salaryTabulatorScale->updated_at = $updated_at;
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
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Payroll\Models\PayrollSalaryTabulator $salaryTabulator  Datos del tabulador salarial
     * @return \Illuminate\Http\JsonResponse                                    Objeto con los registros a mostrar
     */
    public function destroy(PayrollSalaryTabulator $salaryTabulator)
    {
        $salaryTabulator->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene el listado de los tabuladores salariales registrados a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array  Listado de registros a mostrar
     */
    public function getSalaryTabulators()
    {
        return template_choices('Modules\Payroll\Models\PayrollSalaryTabulator', 'name', '', true);
    }
}
