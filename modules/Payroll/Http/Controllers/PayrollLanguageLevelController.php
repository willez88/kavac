<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollLanguageLevel;

/**
 * @class PayrollLanguageLevelController
 * @brief Controlador del nivel de idioma
 *
 * Clase que gestiona los niveles de idioma
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollLanguageLevelController extends Controller
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
        $this->middleware('permission:payroll.language.levels.list', ['only' => 'index']);
        $this->middleware('permission:payroll.language.levels.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.language.levels.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.language.levels.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros del nivel de idioma
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos del nivel de idioma
     */
    public function index()
    {
        return response()->json(['records' => PayrollLanguageLevel::all()], 200);
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
     * Valida y registra un nuevo nivel de idioma
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
        $payrollLanguageLevel = PayrollLanguageLevel::create(['name' => $request->name]);
        return response()->json(['record' => $payrollLanguageLevel, 'message' => 'Success'], 200);
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
     * Actualiza la información del nivel de idioma
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del nivel de idioma  a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollLanguageLevel = PayrollLanguageLevel::find($id);
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $payrollLanguageLevel->name  = $request->name;
        $payrollLanguageLevel->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el nivel de idioma
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del nivel de idioma a eliminar
     * @return \Illuminate\Http\JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollLanguageLevel = PayrollLanguageLevel::find($id);
        $payrollLanguageLevel->delete();
        return response()->json(['record' => $payrollLanguageLevel, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los niveles de idioma registrados
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos del nivel de idioma
     */
    public function getPayrollLanguageLevels()
    {
        return response()->json(template_choices('Modules\Payroll\Models\PayrollLanguageLevel', 'name', '', true));
    }
}
