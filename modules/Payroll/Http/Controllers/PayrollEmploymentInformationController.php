<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollEmploymentInformation;

/**
 * @class PayrollEmploymentInformationController
 * @brief Controlador de información laboral
 *
 * Clase que gestiona los datos de información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollEmploymentInformationController extends Controller
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
        $this->middleware('permission:payroll.employment.informations.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.employment.informations.create', ['only' => 'store']);
        $this->middleware('permission:payroll.employment.informations.edit', ['only' => ['create', 'update']]);
        $this->middleware('permission:payroll.employment.informations.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de información laboral
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::employment-informations.index');
    }

    /**
     * Muestra el formulario de registro de información laboral
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::employment-informations.create-edit');
    }

    /**
     * Valida y registra una nueva información laboral
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payroll_staff_id' => 'required|unique:payroll_employment_informations,payroll_staff_id',
        ]);
        $payroll_employment_information = new PayrollEmploymentInformation;
        $payroll_employment_information->payroll_staff_id  = $request->payroll_staff_id;
        $payroll_employment_information->save();
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.employment-informations.index')], 200);
    }

    /**
     * Muestra los datos de una información laboral en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador de la información laboral
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información laboral
     */
    public function show($id)
    {
        $payroll_employment_information = PayrollEmploymentInformation::where('id',$id)->with(['payroll_staff'])->first();
        return response()->json(['record' => $payroll_staff], 200);
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
