<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollGender;

/**
 * @class PayrollGenderController
 * @brief Controlador del género
 *
 * Clase que gestiona los géneros
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollGenderController extends Controller
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
        $this->middleware('permission:payroll.genders.list', ['only' => 'index']);
        $this->middleware('permission:payroll.genders.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.genders.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.genders.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de cargos
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de cargos
     */
    public function index()
    {
        return response()->json(['records' => PayrollGender::all()], 200);
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
     * Valida y registra un nuevo género
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $payrollGender = PayrollGender::create(['name' => $request->name]);
        return response()->json(['record' => $payrollGender, 'message' => 'Success'], 200);
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
     * Actualiza la información del género
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del género a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollGender = PayrollGender::find($id);
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $payrollGender->name  = $request->name;
        $payrollGender->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el género
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del género a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollGender = PayrollGender::find($id);
        $payrollGender->delete();
        return response()->json(['record' => $payrollGender, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los géneros registrados
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los géneros
     */
    public function getPayrollGenders()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollGender','name','',true));
    }
}
