<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPositionType;

/**
 * @class PositionTypeController
 * @brief Controlador de tipos de cargo
 *
 * Clase que gestiona los tipos de cargo
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollPositionTypeController extends Controller
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
        $this->middleware('permission:payroll.position.types.list', ['only' => 'index']);
        $this->middleware('permission:payroll.position.types.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.position.types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.position.types.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de tipos de cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los tipos de cargo
     */
    public function index()
    {
        return response()->json(['records' => PayrollPositionType::all()], 200);
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
     * Valida y registra un nuevo tipo de cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $payrollPositionType = PayrollPositionType::create([
            'name' => $request->name, 'description' => $request->description
        ]);
        return response()->json(['record' => $payrollPositionType, 'message' => 'Success'], 200);
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
     * Actualiza la información del tipo de cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del tipo de cargo a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollPositionType = PayrollPositionType::find($id);
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $payrollPositionType->name  = $request->name;
        $payrollPositionType->description = $request->description;
        $payrollPositionType->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del tipo de cargo a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollPositionType = PayrollPositionType::find($id);
        $payrollPositionType->delete();
        return response()->json(['record' => $payrollPositionType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de cargo registrados
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los tipos de cargo
     */
    public function getPayrollPositionTypes()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollPositionType', 'name', '', true));
    }
}
