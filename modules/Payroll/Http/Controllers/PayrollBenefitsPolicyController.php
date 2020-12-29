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
            'minimum_number_months'                 => ['required'],
            'additional_days_per_year'              => ['required'],
            'minimum_number_years'                  => ['required'],
            'maximum_additional_days_per_year'      => ['required'],
            'work_interruption_days'                => ['required'],
            'month_worked_days'                     => ['required'],
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'                             => 'El campo nombre es obligatorio.',
            'start_date.required'                       => 'El campo desde (fecha de aplicación) es obligatorio.',
            'benefit_days.required'                     => 'El campo días a cancelar por garantías de prestaciones ' .
                                                           'sociales es obligatorio.',
            'minimum_number_months.required'            => 'El campo número mínimo de meses para el pago de ' .
                                                           'prestaciones sociales es obligatorio.',
            'additional_days_per_year.required'         => 'El campo días adicionales a otorgar para el pago de ' .
                                                           'prestaciones por año de servicio es obligatorio.',
            'minimum_number_years.required'             => 'El campo número mínimo de años para agregar los días ' .
                                                           'adicionales al pago de prestaciones es obligatorio.',
            'maximum_additional_days_per_year.required' => 'El campo número máximo de días adicionales a otorgar ' .
                                                           'para el pago de prestaciones por año de servicio ' .
                                                           'es obligatorio.',
            'work_interruption_days.required'           => 'El campo días a cancelar por interrupción laboral '.
                                                           'es obligatorio.',
            'month_worked_days.required'                => 'El campo días a cancelar por mes trabajado es obligatorio.',
            'salary_type.required'                      => 'El campo salario a emplear para el cálculo de las' .
                                                           'prestaciones sociales es obligatorio.'
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
            [
                'records' => PayrollBenefitsPolicy::where('institution_id', $institution->id)
                                                  ->where('active', true)->get()
            ],
            200
        );
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
        $this->validate($request, $validateRules, $this->messages);
        //
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payroll::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
