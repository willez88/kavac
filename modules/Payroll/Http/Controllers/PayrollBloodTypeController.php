<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollBloodType;

/**
 * @class PayrollBloodTypeController
 * @brief Controlador de tipos de sangre
 *
 * Clase que gestiona los tipos de sangre
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollBloodTypeController extends Controller
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
        $this->middleware('permission:payroll.blood.types.list', ['only' => 'index']);
        $this->middleware('permission:payroll.blood.types.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.blood.types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.blood.types.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de tipos de sangre
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => PayrollBloodType::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payroll::create');
    }

    /**
     * Valida y registra un nuevo tipo de sangre
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50', 'unique:payroll_blood_types,name']
        ]);

        $payrollBloodType = PayrollBloodType::create([
            'name' => $request->name
        ]);
        return response()->json(['record' => $payrollBloodType, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('payroll::edit');
    }

    /**
     * Actualiza la información de tipos de sangre
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del tipo de sangre a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollBloodType = PayrollBloodType::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:50', 'unique:payroll_blood_types,name,'.$payrollBloodType->id]
        ]);

        $payrollBloodType->name = $request->name;
        $payrollBloodType->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de sangre
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del tipo de sangre a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollBloodType = PayrollBloodType::find($id);
        $payrollBloodType->delete();
        return response()->json(['record' => $payrollBloodType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de sangre
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los tipos de sangre
     */
    public function getPayrollBloodTypes()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollBloodType', 'name', '', true));
    }
}
