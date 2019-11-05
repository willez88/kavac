<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSalaryAssignmentType;

/**
 * @class PayrollSalaryAssignmentTypeController
 * @brief Controlador de tipos de asignaciones salariales
 *
 * Clase que gestiona los tipos de asignaciones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryAssignmentTypeController extends Controller
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
        //$this->middleware('permission:asset.setting.salary-assignment-type');
    }
    
    /**
     * Muestra un listado de los tipos de asignaciones salariales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollSalaryAssignmentType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo de asignación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request Datos de la petición
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required']
        ]);


        $assignment_type = PayrollSalaryAssignmentType::create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return response()->json(['record' => $assignment_type, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de asignación salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request Datos de la petición
     * @param  \Modules\Payroll\Models\PayrollSalaryAssignmentType  $assignment_type Datos del Tipo de asignación
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $assignment_type = PayrollSalaryAssignmentType::find($id);
        $this->validate($request, [
            'name' => ['required']
        ]);
 
        $assignment_type->name = $request->input('name');
        $assignment_type->description = $request->input('description');
        $assignment_type->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el tipo de asignación salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Payroll\Models\PayrollSalaryAssignmentType  $assignment_type (Datos del tipo de asignación)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $assignment_type = PayrollSalaryAssignmentType::find($id);
        $assignment_type->delete();
        return response()->json(['record' => $assignment_type, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de los tipos de asignaciones salariales a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return [Array] Arreglo con los registros a mostrar
     */
    public function getAssignmentTypes()
    {
        return template_choices('Modules\Payroll\Models\PayrollSalaryAssignmentType', 'name', '', true);
    }
}
