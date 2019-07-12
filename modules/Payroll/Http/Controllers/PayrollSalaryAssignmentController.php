<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSalaryAssignmentType;
use Modules\Payroll\Models\PayrollSalaryAssignment;
use Modules\Payroll\Models\PayrollPositionType;
use Modules\Payroll\Models\PayrollSalaryScale;
use Modules\Payroll\Models\PayrollScale;

/**
 * @class PayrollSalaryAssignmentController
 * @brief Controlador de las asignaciones de nómina
 *
 * Clase que gestiona los tipos de asignaciones de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollSalaryAssignmentController extends Controller
{
    use ValidatesRequests;
    
    /**
     * Muestra un listado de las asignaciones salariales registradas (activas e inactivas)
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryAssignment::all()], 200);
    }

    /**
     * Valida y registra un nueva asignación salarial
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'incidence_type' => 'required',
            'position_type_id' => 'required',
            'assignment_type_id' => 'required',
            'salary_scale.name' => 'required',
            'salary_scale.scales' => 'required',
        ]);

        DB::transaction(function() use ($request) {
            /**
             * Objeto con la información del nuevo escalafón salarial
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

}
