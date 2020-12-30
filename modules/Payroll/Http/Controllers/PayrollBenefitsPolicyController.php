<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollBenefitsPolicy;
use Modules\Payroll\Models\Institution;

/**
 * @class      PayrollBenefitsPolicyController
 * @brief      Controlador de políticas de prestaciones sociales
 *
 * Clase que gestiona las políticas de prestaciones sociales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollBenefitsPolicyController extends Controller
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
        //$this->middleware('permission:payroll.benefits-policies.list',   ['only' => 'index']);
        //$this->middleware('permission:payroll.benefits-policies.create', ['only' => 'store']);
        //$this->middleware('permission:payroll.benefits-policies.edit',   ['only' => 'update']);
        //$this->middleware('permission:payroll.benefits-policies.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'name'                                  => ['required'],
            'start_date'                            => ['required'],
            'institution_id'                        => ['required'],
            'minimum_number_months'                 => ['required'],
            'additional_days_per_year'              => ['required'],
            'minimum_number_years'                  => ['required'],
            'additional_maximum_days_per_year'      => ['required'],
            'work_interruption_days'                => ['required'],
            'month_worked_days'                     => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'                             => 'El campo nombre es obligatorio.',
            'start_date.required'                       => 'El campo desde (fecha de aplicación) es obligatorio.',
            'institution_id.required'                   => 'El campo institución es obligatorio.',
            'benefit_days.required'                     => 'El campo días a cancelar por garantías de prestaciones ' .
                                                           'sociales es obligatorio.',
            'minimum_number_months.required'            => 'El campo número mínimo de meses para el pago de ' .
                                                           'prestaciones sociales es obligatorio.',
            'additional_days_per_year.required'         => 'El campo días adicionales a otorgar para el pago de ' .
                                                           'prestaciones por año de servicio es obligatorio.',
            'minimum_number_years.required'             => 'El campo número mínimo de años para agregar los días ' .
                                                           'adicionales al pago de prestaciones es obligatorio.',
            'additional_maximum_days_per_year.required' => 'El campo número máximo de días adicionales a otorgar ' .
                                                           'para el pago de prestaciones por año de servicio ' .
                                                           'es obligatorio.',
            'work_interruption_days.required'           => 'El campo días a cancelar por interrupción laboral '.
                                                           'es obligatorio.',
            'month_worked_days.required'                => 'El campo días a cancelar por mes trabajado es obligatorio.',
            'maximum_advance_percentage.required'       => 'El campo porcentaje máximo permitido para el anticipo ' .
                                                           'de prestaciones es obligatorio.',
            'number_advances_per_year.required'         => 'El campo número de anticipos permitidos por año ' .
                                                           'es obligatorio.',
            'salary_type.required'                      => 'El campo salario a emplear para el cálculo de las' .
                                                           'prestaciones sociales es obligatorio.',
            'payroll_payment_type_id.required'          => 'El campo tipo de pago de nómina es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de las políticas de prestaciones registradas
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
            ['records' => PayrollBenefitsPolicy::where('institution_id', $institution->id)->get()],
            200
        );
    }

    /**
     * Valida y registra una nueva política de prestaciones
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
        if ($request->input('benefits_advance_payment') == true) {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'maximum_advance_percentage' => ['required'],
                    'number_advances_per_year'   => ['required'],
                    'salary_type'                => ['required'],
                    'payroll_payment_type_id'    => ['required']
                ]
            );
        } elseif ($request->input('benefits_advance_payment') == false) {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'salary_type'                => ['required'],
                    'payroll_payment_type_id'    => ['required']
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
        /** Validar el rol del usuario
         *  Si es el administrador asigne la intitución seleccionada en el formulario,
         *  en caso contrario, asignar institución asociada al usuario
         */

        /**
         * Objeto asociado al modelo PayrollBenefitsPolicy
         *
         * @var Object $payrollBenefitsPolicy
         */
        $payrollBenefitsPolicy = PayrollBenefitsPolicy::create([
            'name'                             => $request->input('name'),
            'active'                           => !empty($request->active)
                                                    ? $request->active
                                                    : false,
            'start_date'                       => $request->input('start_date'),
            'end_date'                         => $request->input('end_date'),
            'benefit_days'                     => $request->input('benefit_days'),
            'minimum_number_months'            => $request->input('minimum_number_months'),
            'additional_days_per_year'         => $request->input('additional_days_per_year'),
            'minimum_number_years'             => $request->input('minimum_number_years'),
            'additional_maximum_days_per_year' => $request->input('additional_maximum_days_per_year'),
            'work_interruption_days'           => $request->input('work_interruption_days'),
            'month_worked_days'                => $request->input('month_worked_days'),
            'benfits_advance_payment'          => !empty($request->benfits_advance_payment)
                                                    ? $request->benfits_advance_payment
                                                    : false,
            'maximum_advance_percentage'       => $request->input('maximum_advance_percentage'),
            'number_advances_per_year'         => $request->input('number_advances_per_year'),
            'salary_type'                      => $request->input('salary_type'),
            'institution_id'                   => $request->input('institution_id'),
            'payroll_payment_type_id'          => $request->input('payroll_payment_type_id')
        ]);
        return response()->json(['record' => $payrollBenefitsPolicy, 'message' => 'Success'], 200);
    }

    /**
     * Muestra los datos de la información de la política de prestaciones seleccionada
     *
     * @method    show
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer    $id                   Identificador único de la política de prestaciones
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function show($id)
    {
        $payrollBenefitsPolicy = PayrollBenefitsPolicy::find($id);
        return response()->json(['record' => $payrollBenefitsPolicy], 200);
    }

    /**
     * Actualiza la información de una política de prestaciones
     *
     * @method    update
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único de la política de prestaciones
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto asociado al modelo PayrollBenefitsPolicy
         *
         * @var Object $payrollBenefitsPolicy
         */
        $payrollBenefitsPolicy = PayrollBenefitsPolicy::find($id);

        $validateRules  = $this->validateRules;
        if ($request->input('benefits_advance_payment') == true) {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'maximum_advance_percentage' => ['required'],
                    'number_advances_per_year'   => ['required'],
                    'salary_type'                => ['required'],
                    'payroll_payment_type_id'    => ['required']
                ]
            );
        } elseif ($request->input('benefits_advance_payment') == false) {
            $validateRules  = array_merge(
                $validateRules,
                [
                    'salary_type'                => ['required'],
                    'payroll_payment_type_id'    => ['required']
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
        /** Validar el rol del usuario
         *  Si es el administrador asigne la intitución seleccionada en el formulario,
         *  en caso contrario, asignar institución asociada al usuario
         */
        
        $payrollBenefitsPolicy->update([
            'name'                             => $request->input('name'),
            'active'                           => !empty($request->active)
                                                    ? $request->active
                                                    : false,
            'start_date'                       => $request->input('start_date'),
            'end_date'                         => $request->input('end_date'),
            'benefit_days'                     => $request->input('benefit_days'),
            'minimum_number_months'            => $request->input('minimum_number_months'),
            'additional_days_per_year'         => $request->input('additional_days_per_year'),
            'minimum_number_years'             => $request->input('minimum_number_years'),
            'additional_maximum_days_per_year' => $request->input('additional_maximum_days_per_year'),
            'work_interruption_days'           => $request->input('work_interruption_days'),
            'month_worked_days'                => $request->input('month_worked_days'),
            'benfits_advance_payment'          => !empty($request->benfits_advance_payment)
                                                    ? $request->benfits_advance_payment
                                                    : false,
            'maximum_advance_percentage'       => $request->input('maximum_advance_percentage'),
            'number_advances_per_year'         => $request->input('number_advances_per_year'),
            'salary_type'                      => $request->input('salary_type'),
            'institution_id'                   => $request->input('institution_id'),
            'payroll_payment_type_id'          => $request->input('payroll_payment_type_id')
        ]);

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina una política de prestaciones
     *
     * @method    destroy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer       $id    Identificador único de la política de prestaciones a eliminar
     *
     * @return    Renderable
     */
    public function destroy($id)
    {
        /**
         * Objeto asociado al modelo PayrollBenefitsPolicy
         *
         * @var Object $payrollBenefitsPolicy
         */
        $payrollBenefitsPolicy = PayrollBenefitsPolicy::find($id);
        $payrollBenefitsPolicy->delete();
        return response()->json(['record' => $payrollBenefitsPolicy, 'message' => 'Success'], 200);
    }
}
