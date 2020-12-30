<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollVacationPolicy;
use Modules\Payroll\Models\Institution;

/**
 * @class      PayrollVacationPolicyController
 * @brief      Controlador de políticas vacacionales
 *
 * Clase que gestiona las políticas vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollVacationPolicyController extends Controller
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
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.vacation-policies.list',   ['only' => 'index']);
        //$this->middleware('permission:payroll.vacation-policies.create', ['only' => 'store']);
        //$this->middleware('permission:payroll.vacation-policies.edit',   ['only' => 'update']);
        //$this->middleware('permission:payroll.vacation-policies.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'                                  => ['required'],
            'start_date'                            => ['required'],
            'vacation_type'                         => ['required'],
            'staff_antiquity'                       => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'                                  => 'El campo nombre es obligatorio.',
            'start_date.required'                            => 'El campo desde (fecha de aplicación) es obligatorio.',
            'institution_id.required'                        => 'El campo institución es obligatorio.',
            'vacation_periods.required'                      => 'El campo período(s) vacacional es obligatorio.',
            'vacation_type.required'                         => 'El campo tipo de vacaciones es obligatorio.',
            'vacation_periods_accumulated_per_year.required' => 'El campo períodos vacacionales acumulados por año ' .
                                                                'es obligatorio.',
            'vacation_days.required'                         => 'El campo días a otorgar para el disfrute de ' .
                                                                'vacaciones es obligatorio.',
            'vacation_period_per_year.required'              => 'El campo períodos vacacionales permitidos por año ' .
                                                                'es obligatorio.',
            'additional_days_per_year.required'              => 'El campo días adicionales a otorgar para el ' .
                                                                'disfrute de vacaciones es obligatorio.',
            'minimum_additional_days_per_year.required'      => 'El campo días de disfrute de vacaciones mínimo ' .
                                                                'por año de servicio es obligatorio.',
            'maximum_additional_days_per_year.required'      => 'El campo días de disfrute de vacaciones máximo ' .
                                                                'por año de servicio es obligatorio.',
            'salary_type.required'                           => 'El campo salario a emplear para el cálculo del bono ' .
                                                                'vacacional es obligatorio.',
            'payroll_payment_type_id.required'               => 'El campo tipo de pago de nómina es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de las políticas vacacionales registradas
     *
     * @method    index
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        return response()->json(
            ['records' => PayrollVacationPolicy::where('institution_id', $institution->id)->get()],
            200
        );
    }

    /**
     * Muestra los datos de la información de la política vacacional seleccionada
     *
     * @method    show
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer    $id                Identificador único de la política vacacional
     *
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function show($id)
    {
        $payrollVacationPolicy = PayrollVacationPolicy::find($id);
        return response()->json(['record' => $payrollVacationPolicy], 200);
    }

    /**
     * Valida y registra una nueva política vacacional
     *
     * @method    store
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $validateRules  = $this->validateRules;
        if ($request->input('vacation_type') == 'collective_vacations') {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'vacation_periods_accumulated_per_year' => ['required'],
                    'vacation_periods'                      => ['required'],
                    'salary_type'                           => ['required'],
                    'payroll_payment_type_id'               => ['required']
                ]
            );
            if ($request->input('payment_calculation') == 'general_days') {
                $validateRules  = array_merge(
                    $validateRules,
                    ['vacation_days' => ['required']]
                );
            }
        } elseif ($request->input('vacation_type') == 'vacation_period') {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'vacation_periods_accumulated_per_year' => ['required'],
                    'vacation_period_per_year'              => ['required'],
                    'additional_days_per_year'              => ['required'],
                    'minimum_additional_days_per_year'      => ['required'],
                    'maximum_additional_days_per_year'      => ['required'],
                    'payroll_payment_type_id'               => ['required']
                ]
            );
        }
        $this->validate($request, $validateRules, $this->messages);

        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        /**
         * Objeto asociado al modelo PayrollVacationPolicy
         *
         * @var Object $payrollVacationPolicy
         */
        $payrollVacationPolicy = PayrollVacationPolicy::create([
            'name'                                  => $request->input('name'),
            'active'                                => !empty($request->active)
                                                        ? $request->active
                                                        : false,
            'start_date'                            => $request->input('start_date'),
            'end_date'                              => $request->input('end_date'),
            'vacation_periods'                      => json_encode($request->input('vacation_periods')),
            'vacation_type'                         => $request->input('vacation_type'),
            'vacation_periods_accumulated_per_year' => $request->input('vacation_periods_accumulated_per_year'),
            'vacation_days'                         => $request->input('vacation_days'),
            'vacation_period_per_year'              => $request->input('vacation_period_per_year'),
            'additional_days_per_year'              => $request->input('additional_days_per_year'),
            'minimum_additional_days_per_year'      => $request->input('minimum_additional_days_per_year'),
            'maximum_additional_days_per_year'      => $request->input('maximum_additional_days_per_year'),
            'payment_calculation'                   => $request->input('payment_calculation'),
            'salary_type'                           => $request->input('salary_type'),
            'vacation_advance'                      => $request->input('vacation_advance'),
            'vacation_postpone'                     => $request->input('vacation_postpone'),
            'staff_antiquity'                       => $request->input('staff_antiquity'),
            'institution_id'                        => $request->input('institution_id'),
            'payroll_payment_type_id'               => $request->input('payroll_payment_type_id')
        ]);
        return response()->json(['record' => $payrollVacationPolicy, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una política vacacional
     *
     * @method    update
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único de la política vacacional
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationPolicy
         *
         * @var Object $payrollVacationPolicy
         */
        $payrollVacationPolicy = PayrollVacationPolicy::find($id);

        $validateRules  = $this->validateRules;
        if ($request->input('vacation_type') == 'collective_vacations') {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'vacation_periods_accumulated_per_year' => ['required'],
                    'vacation_periods'                      => ['required'],
                    'salary_type'                           => ['required'],
                    'payroll_payment_type_id'               => ['required']
                ]
            );
            if ($request->input('payment_calculation') == 'general_days') {
                $validateRules  = array_merge(
                    $validateRules,
                    ['vacation_days' => ['required']]
                );
            }
        } elseif ($request->input('vacation_type') == 'vacation_period') {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'vacation_periods_accumulated_per_year' => ['required'],
                    'vacation_period_per_year'              => ['required'],
                    'additional_days_per_year'              => ['required'],
                    'minimum_additional_days_per_year'      => ['required'],
                    'maximum_additional_days_per_year'      => ['required'],
                    'payroll_payment_type_id'               => ['required']
                ]
            );
        }
        $this->validate($request, $validateRules, $this->messages);

        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        
        $payrollVacationPolicy->update([
            'name'                                  => $request->input('name'),
            'active'                                => !empty($request->active)
                                                        ? $request->active
                                                        : false,
            'start_date'                            => $request->input('start_date'),
            'end_date'                              => $request->input('end_date'),
            'vacation_periods'                      => json_encode($request->input('vacation_periods')),
            'vacation_type'                         => $request->input('vacation_type'),
            'institution_id'                        => $institution->id,
            'vacation_periods_accumulated_per_year' => $request->input('vacation_periods_accumulated_per_year'),
            'vacation_days'                         => $request->input('vacation_days'),
            'vacation_period_per_year'              => $request->input('vacation_period_per_year'),
            'additional_days_per_year'              => $request->input('additional_days_per_year'),
            'minimum_additional_days_per_year'      => $request->input('minimum_additional_days_per_year'),
            'maximum_additional_days_per_year'      => $request->input('maximum_additional_days_per_year'),
            'payment_calculation'                   => $request->input('payment_calculation'),
            'salary_type'                           => $request->input('salary_type'),
            'vacation_advance'                      => $request->input('vacation_advance'),
            'vacation_postpone'                     => $request->input('vacation_postpone'),
            'staff_antiquity'                       => $request->input('staff_antiquity'),
            'institution_id'                        => $request->input('institution_id'),
            'payroll_payment_type_id'               => $request->input('payroll_payment_type_id')
        ]);

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina una política vacacional
     *
     * @method    destroy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único de la política vacacional a eliminar
     *
     * @return    Renderable
     */
    public function destroy($id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationPolicy
         *
         * @var Object $payrollVacationPolicy
         */
        $payrollVacationPolicy = PayrollVacationPolicy::find($id);
        $payrollVacationPolicy->delete();
        return response()->json(['record' => $payrollVacationPolicy, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de la información de la política vacacional según la institución asociada 
     * al trabajador autenticado
     *
     * @method    getVacationPolicy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function getVacationPolicy()
    {
        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        
        $payrollVacationPolicy = PayrollVacationPolicy::where('institution_id', $institution->id)->first();
        return response()->json(['record' => $payrollVacationPolicy], 200);
    }
}
