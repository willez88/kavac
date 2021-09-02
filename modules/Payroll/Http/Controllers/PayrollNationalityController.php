<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollNationality;

/**
 * @class PayrollNationalityController
 * @brief Controlador de nacionalidad
 *
 * Clase que gestiona las nacionalidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class PayrollNationalityController extends Controller
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
        $this->middleware('permission:payroll.nationalities.list', ['only' => 'index']);
        $this->middleware('permission:payroll.nationalities.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.nationalities.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.nationalities.delete', ['only' => 'destroy']);

        /** Define los atributos para los campos personalizados */
        $this->attributes = [
            'country_id' => 'país',
        ];
    }

    /**
     * Muestra todos los registros de nacionalidades
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de nacionalidades
     */
    public function index()
    {
        return response()->json(['records' => PayrollNationality::with(['country'])->get()], 200);
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
     * Valida y registra una nueva nacionalidad
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->rules['name'] = ['required', 'unique:payroll_nationalities,name'];
        $this->rules['country_id'] = ['required', 'unique:payroll_nationalities,country_id'];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollNationality = PayrollNationality::create([
            'name' => $request->name, 'country_id' => $request->country_id
        ]);
        return response()->json(['record' => $payrollNationality, 'message' => 'Success'], 200);
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
     * Actualiza la información de la nacionalidad
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador de la nacionalidad a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollNationality = PayrollNationality::find($id);
        $this->rules['name'] = ['required', 'unique:payroll_nationalities,name,' . $payrollNationality->id];
        $this->rules['country_id'] = ['required', 'unique:payroll_nationalities,country_id,'. $payrollNationality->id];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollNationality->name = $request->name;
        $payrollNationality->country_id = $request->country_id;
        $payrollNationality->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la nacionalidad
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador de la nacionalidad a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollNationality = PayrollNationality::find($id);
        $payrollNationality->delete();
        return response()->json(['record' => $payrollNationality, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las nacionalidades registrados
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de nacionalidades
     */
    public function getPayrollNationalities()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollNationality', 'name', '', true));
    }
}
