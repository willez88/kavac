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
use Modules\Payroll\Models\PayrollScaleRequirement;
use App\Models\Institution;

/**
 * @class PayrollSalaryScaleController
 * @brief Controlador de los escalafones salariales
 *
 * Clase que gestiona los escalafones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryScaleController extends Controller
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
        //$this->middleware('permission:payroll.setting.salary-scale');
    }
    
    /**
     * Muestra un listado de los escalafones salariales registrados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryScale::with(['payrollScales' => function ($query) {
            $query->with('PayrollScaleRequirements')->orderBy('code');
        }])->get()], 200);
    }

    /**
     * Valida y registra un nuevo escalafón salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request Datos de la petición
     * @return \Illuminate\Http\Response          Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code'           => ['required'],
            'name'           => ['required'],
            'institution_id' => ['required'],
            'payroll_scales' => ['required'],
        ]);
        /**
         * Crear regla para validar las escalas (payroll_scales)
         * y los requerimentos de las mismas (payroll_scale_requirements)
         */
        DB::transaction(function () use ($request) {
            $salaryScale = PayrollSalaryScale::create([
                'code'                   => $request->input('code'),
                'name'                   => $request->input('name'),
                'active'                 => !empty($request->input('active'))?$request->input('active'):false,
                'description'            => $request->input('description'),
                'institution_id'         => $request->input('institution_id'),
                'group_by_years'         => $request->input('group_by_years'),
                'group_by_clasification' => $request->input('group_by_clasification'),
            ]);
            foreach ($request->payroll_scales as $payrollScale) {
                $scale = PayrollScale::create([
                    'code'                    => $payrollScale['code'],
                    'name'                    => $payrollScale['name'],
                    'description'             => $payrollScale['description'],
                    'payroll_salary_scale_id' => $salaryScale->id,
                ]);
                $payrollScaleRequirements = $payrollScale['payroll_scale_requirements'];
                foreach ($payrollScaleRequirements as $payrollScaleRequirement) {
                    $scaleRequirement = PayrollScaleRequirement::create([
                        'payroll_scale_id'    => $scale->id,
                        'scale_years_minimum' => $payrollScaleRequirement['scale_years_minimum'],
                        'scale_years_maximum' => $payrollScaleRequirement['scale_years_maximum'],
                    ]);
                    if ($request->group_by_clasification === "position") {
                        /** @var object Objeto que contiene información de un cargo */
                        $posInst = PayrollPosition::find($payrollScaleRequirement['clasificable_id']);
                        $posInst->payrollScaleRequirements()->save($scaleRequirement);
                    } elseif ($request->group_by_clasification === "instruction_degree") {
                        /** @var object Objeto que contiene información de un grado de instrucción */
                        $posInst = PayrollInstructionDegree::find($payrollScaleRequirement['clasificable_id']);
                        $posInst->payrollScaleRequirements()->save($scaleRequirement);
                    }
                }
            }
        });
        return response()->json(['result' => true], 200);
    }

    /**
     * Actualiza la información del escalafón salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id                        Identificador único del registro asociado al escalafón salarial
     * @param  \Illuminate\Http\Request  $request Datos de la petición
     * @return \Illuminate\Http\JsonResponse      Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        $payrollSalaryScale = PayrollSalaryScale::find($id);
        $this->validate($request, [
            'code'           => ['required'],
            'name'           => ['required'],
            'institution_id' => ['required'],
            'payroll_scales' => ['required'],
        ]);
        DB::transaction(function () use ($request, $payrollSalaryScale) {
            $payrollSalaryScale->code                   = $request->input('code');
            $payrollSalaryScale->name                   = $request->input('name');
            $payrollSalaryScale->description            = $request->input('description');
            $payrollSalaryScale->institution_id         = $request->input('institution_id');
            $payrollSalaryScale->active                 = !empty($request->input('active'))
                                                              ? $request->input('active')
                                                              : $payrollSalaryScale->active;
            $payrollSalaryScale->group_by_years         = $request->input('group_by_years');
            $payrollSalaryScale->group_by_clasification = $request->input('group_by_clasification');
            $payrollSalaryScale->save();
            $updated_at = now();

            /** Se agregan los nuevos niveles o escalas y se actualizan los existentes */
            foreach ($request->payroll_scales as $payrollScale) {
                if ($payrollScale['id'] > 0) {
                    $scale              = PayrollScale::find($payrollScale['id']);
                    $scale->code        = $payrollScale['code'];
                    $scale->name        = $payrollScale['name'];
                    $scale->description = $payrollScale['description'];
                    $scale->updated_at  = $updated_at;
                    $scale->save();
                } else {
                    $scale = PayrollScale::Create([
                        'code'                    => $payrollScale['code'],
                        'name'                    => $payrollScale['name'],
                        'description'             => $payrollScale['description'],
                        'payroll_salary_scale_id' => $payrollSalaryScale->id,
                        'updated_at'              => $updated_at,
                    ]);
                }
                $payrollScaleRequirements = $payrollScale['payroll_scale_requirements'];
                
                foreach ($payrollScaleRequirements as $payrollScaleRequirement) {
                    $scaleRequirement = PayrollScaleRequirement::updateOrCreate([
                        'payroll_scale_id'    => $scale->id,
                        'scale_years_minimum' => $payrollScaleRequirement['scale_years_minimum'],
                        'scale_years_maximum' => $payrollScaleRequirement['scale_years_maximum'],
                    ]);
                    $posInst = null;
                    if ($request->group_by_clasification === "position") {
                        /** @var object Objeto que contiene información de un cargo */
                        $posInst           = PayrollPosition::find(
                            $payrollScaleRequirement['clasificable_id']
                        );
                        $clasificable_type = PayrollPosition::class;
                    } elseif ($request->group_by_clasification === "instruction_degree") {
                        /** @var object Objeto que contiene información de un grado de instrucción */
                        $posInst           = PayrollInstructionDegree::find(
                            $payrollScaleRequirement['clasificable_id']
                        );
                        $clasificable_type = PayrollInstructionDegree::class;
                    }
                    if ($posInst) {
                        $scaleRequirement->clasificable_type = $clasificable_type;
                        $scaleRequirement->clasificable_id   = $posInst->id;
                    }
                    $scaleRequirement->updated_at = $updated_at;
                    $scaleRequirement->save();
                }
            }

            /** Se eliminan los demas niveles o escalas del escalafón salarial */
            $payrollScales = PayrollScale::where('payroll_salary_scale_id', $payrollSalaryScale->id)
                ->with('payrollScaleRequirements')->get();

            foreach ($payrollScales as $payrollScale) {
                $scaleRequirements = PayrollScaleRequirement::where('payroll_scale_id', $payrollScale->id)
                    ->where('updated_at', '!=', $updated_at)->get();

                foreach ($scaleRequirements as $scaleRequirement) {
                    $scaleRequirement->delete();
                }
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
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Payroll\Models\PayrollSalaryScale $salaryScale Datos del escalafón salarial
     * @return \Illuminate\Http\JsonResponse                           Objeto con los registros a mostrar
     */
    public function destroy(PayrollSalaryScale $salaryScale)
    {
        $salaryScale->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Obtiene el listado de los escalafones salariales a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array Listado de los registros a mostrar
     */
    public function getSalaryScales(Request $request)
    {
        $institution  = $request->institution_id ?? Institution::where([
            'default' => true,
            'active'  => true
        ])->first();
        return template_choices(
            'Modules\Payroll\Models\PayrollSalaryScale',
            'name',
            [
                'institution_id'         => $request->institution_id ?? $institution->id,
                'group_by_years'         => $request->group_by_years,
                'group_by_clasification' => $request->group_by_clasification,
            ],
            true
        );
    }

    /**
     * Obtiene la información de un escalafón salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id                   Identificador único del escalafón salarial
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function info($id)
    {
        return response()->json(['record' => PayrollSalaryScale::where('id', $id)
            ->with('payrollScales')->first()], 200);
    }
}
