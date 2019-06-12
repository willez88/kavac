<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollAssignmentType;

/**
 * @class PayrollAssignmentTypeController
 * @brief Controlador de tipos de asignaciones de nómina
 *
 * Clase que gestiona los tipos de asignaciones de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollAssignmentTypeController extends Controller
{
    use ValidatesRequests;
    
    /**
     * Muestra un listado de los tipos de asignación de nómina
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => PayrollAssignmentType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo de asignación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);


        $assignment_type = PayrollAssignmentType::create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return response()->json(['record' => $assignment_type, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de asignación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Payroll\Models\PayrollAssignmentType  $assignment_type (Datos del Tipo de asignación)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function update(Request $request, PayrollAssignmentType $assignment_type)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
 
        $assignment_type->name = $request->input('name');
        $assignment_type->description = $request->input('description');
        $assignment_type->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el Tipo de Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Payroll\Models\PayrollAssignmentType  $assignment_type (Datos del tipo de asignación)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(PayrollAssignmentType $assignment_type)
    {
        $assignment_type->delete();
        return response()->json(['record' => $assignment_type, 'message' => 'Success'], 200);
    }

}
