<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPosition;

/**
 * @class PositionController
 * @brief Controlador de cargos
 *
 * Clase que gestiona los cargos
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollPositionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.positions.list', ['only' => 'index']);
        $this->middleware('permission:payroll.positions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.positions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.positions.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de cargos
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de cargos
     */
    public function index()
    {
        return response()->json(['records' => PayrollPosition::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('payroll::create');
    }

    /**
     * Valida y registra un nuevo cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $payrollPosition = PayrollPosition::create(['name' => $request->name,'description' => $request->description]);
        return response()->json(['record' => $payrollPosition, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('payroll::edit');
    }

    /**
     * Actualiza la información del cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del cargo a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollPosition = PayrollPosition::find($id);
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $payrollPosition->name  = $request->name;
        $payrollPosition->description = $request->description;
        $payrollPosition->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del cargo a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollPosition = PayrollPosition::find($id);
        $payrollPosition->delete();
        return response()->json(['record' => $payrollPosition, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los cargo registrados
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de cargos
     */
    public function getPayrollPositions()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollPosition', 'name', '', true));
    }
}
