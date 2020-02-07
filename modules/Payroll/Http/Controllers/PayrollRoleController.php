<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollRole;

/**
 * @class PayrollRoleController
 * @brief Controlador de roles del trabajador
 *
 * Clase que gestiona los roles
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollRoleController extends Controller
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
        $this->middleware('permission:payroll.roles.list', ['only' => 'index']);
        $this->middleware('permission:payroll.roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.roles.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de roles
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => PayrollRole::all()], 200);
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
     * Valida y registra un nuevo rol
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:100'],
        ]);

        $payrollRole = PayrollRole::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json(['record' => $payrollRole, 'message' => 'Success'], 200);
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
     * Actualiza la información de roles
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del rol a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollRole = PayrollRole::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:100']
        ]);

        $payrollRole->name = $request->name;
        $payrollRole->description = $request->description;
        $payrollRole->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el rol
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del rol a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollRole = PayrollRole::find($id);
        $payrollRole->delete();
        return response()->json(['record' => $payrollRole, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los roles
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los roles
     */
    public function getPayrollRoles()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollRole', 'name', '', true));
    }
}
