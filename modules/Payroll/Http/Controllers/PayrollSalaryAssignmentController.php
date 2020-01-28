<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSalaryAssignment;
use Modules\Payroll\Models\PayrollSalaryScale;
use Modules\Payroll\Models\PayrollScale;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Payroll\Exports\PayrollSalaryAssignmentExport;
use App\User;

/**
 * @class PayrollSalaryAssignmentController
 * @brief Controlador de las asignaciones de nómina
 *
 * Clase que gestiona los tipos de asignaciones de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryAssignmentController extends Controller
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
        //$this->middleware('permission:asset.setting.salary-assignment');
    }
    
    /**
     * Muestra un listado de las asignaciones salariales registradas (activas e inactivas)
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryAssignment::all()], 200);
    }

    /**
     * Valida y registra un nueva asignación salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'incidence_type' => ['required'],
            'position_type_id' => ['required'],
            'assignment_type_id' => ['required'],
            'salary_scale.name' => ['required'],
            'salary_scale.scales' => ['required'],
        ]);

        DB::transaction(function () use ($request) {
            /**
             * Objeto con la información del nuevo escalafón salarial
             *
             * @var object $salary_scale
             */
            $salary_scale = PayrollSalaryScale::create([
                'name' => $request->salary_scale['name'],
                'description' => $request->salary_scale['description'],
                'active' => $request->input('active'),
            ]);

            /**
             * Arreglo que contiene las escalas del escalafón salarial
             * @var array $scales
             */
            $scales = $request->salary_scale['scales'];

            if ($scales && !empty($scales)) {
                foreach ($scales as $scale) {
                    PayrollScale::create([
                        'name' => $scale['name'],
                        'description' => $scale['description'],
                        'value' => $scale['value'],
                        'payroll_salary_scale_id' => $salary_scale->id,
                    ]);
                }
            };

            /**
             * Objeto que contiene la información de la nueva asignación salarial
             * @var object $salary_assignment
             */
            $salary_assignment = PayrollSalaryAssignment::create([
                'name' => $request->input('name'),
                'active' => $request->input('active'),
                'incidence' => $request->input('incidence'),
                'description' => $request->input('description'),
                'incidence_type' => $request->input('incidence_type'),
                'payroll_position_type_id' => $request->input('position_type_id'),
                'payroll_salary_assignment_type_id' => $request->input('assignment_type_id'),
                'payroll_salary_scale_id' => $salary_scale->id,
            ]);
        });

        return response()->json(['record' => $salary_assignment, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una asignación salarial
     *
     * @param  \Illuminate\Http\Request      $request Datos de la petición
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function update(Request $request)
    {
    }

    /**
     * Elimina una asignación salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function destroy()
    {
    }

    /**
     * Exporta una asignacion salarial
     * @param  [Integer] $id Identificador único de la asignación salarial a exportar
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function export($id)
    {
        /*
        $salary_assignment = PayrollSalaryAssignment::find($id);
        if (!is_null($salary_assignment)) {
            $export = new PayrollSalaryAssignmentExport();
            $export->setSalaryAssignmentId($salary_assignment->id);
            return Excel::download($export, 'salary_assignment'. $salary_assignment->created_at . '.xlsx');
        } else {
            return response()->json(['result' => false], 200);
        }*/
    }
}
