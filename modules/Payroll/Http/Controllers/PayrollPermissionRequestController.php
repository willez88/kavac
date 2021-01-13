<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPermissionRequest;

/**
 * @class      PayrollPermissionRequestController
 * @brief      Controlador de solicitudes de permisos
 *
 * Clase que gestiona las solicitudes de permisos
 *
 * @author     Yennifer Ramirez <yramirez@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
*/

class PayrollPermissionRequestController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
    */
    public function index()
    {
        return view('payroll::requests.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
    */

    public function create()
    {
        return view('payroll::requests.permissions.create');
    }

    /**
     * Valida y registra una nueva solicitud de permiso
     *
     * @method    store
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
    */

    public function store(Request $request)
    {
        $this->validate($request, [
            'date'                             => ['required'],
            'payroll_staff_id'                 => ['required'],
            'payroll_permission_policy_id'     => ['required'],
            'start_date'                       => ['required'],
            'end_date'                         => ['required'],
            'day_permission'                   => ['required'],
            'motive_permission'                => ['required', 'max:200'],
        ]);

        $payrollVacationRequest = PayrollVacationRequest::create([
            'status'                           => 'Pendiente',
            'date'                             => $request->date,
            'payroll_staff_id'                 => $request->payroll_staff_id,
            'payroll_permission_policy_id'     => $request->payroll_permission_policy_id,
            'start_date'                       => $request->start_date,
            'end_date'                         => $request->end_date,
            'day_permission'                   => $request->day_permission,
            'motive_permission'                => $request->motive_permission,
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.permission-requests.index')], 200);
    }

    /**
     * Muestra los datos de la información de la solicitud de permiso seleccionada
     *
     * @method    show
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     *
     * @param int $id
     * @return Renderable
    */

    public function show($id)
    {
        $payrollPermissionRequest = PayrollPermissionRequest::find($id);
        return response()->json(['record' => $payrollPermissionRequest], 200);
    }

    /**
     * Muestra el formulario para actualizar la información de una solicitud vacacional
     *
     * @method    edit
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     * @param int $id
     * @return Renderable
    */

    public function edit($id)
    {
        $payrollPermissionRequest = PayrollPermissionRequest::find($id);
        return view('payroll::requests.permissions.create', compact('payrollPermissionRequest'));
    }

    /**
     * Actualiza la información de la solicitud de permiso
     *
     * @method    update
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     * @param Request $request
     * @param int $id
     * @return Renderable
    */
    public function update(Request $request, $id)
    {
        $payrollPermissionRequest = PayrollPermissionRequest::find($id);
        $this->validate($request, [
            'date'                             => ['required'],
            'payroll_staff_id'                 => ['required'],
            'payroll_permission_policy_id'     => ['required'],
            'start_date'                       => ['required'],
            'end_date'                         => ['required'],
            'day_permission'                   => ['required'],
            'motive_permission'                => ['required', 'max:200'],

        ]);
        $payrollPermissionRequest->status                           = 'Pendiente';
        $payrollPermissionRequest->date                             = $request->date;
        $payrollPermissionRequest->payroll_staff_id                 = $request->payroll_staff_id;
        $payrollPermissionRequest->payroll_permission_policy_id     = $request->payroll_permission_policy_id;
        $payrollPermissionRequest->start_date                       = $request->start_date;
        $payrollPermissionRequest->end_date                         = $request->end_date;
        $payrollPermissionRequest->day_permission                   = $request->day_permission ;
        $payrollPermissionRequest->motive_permission                = $request->motive_permission;
        $citizenServiceRequest->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.permission-requests.index')], 200);
    }

    /**
     * Elimina una solicitud de permiso
     *
     * @method    destroy
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     * @param int $id
     * @return Renderable
    */
    public function destroy($id)
    {
        $payrollPermissionRequest = PayrollPermissionRequest::find($id);
        $payrollPermissionRequest->delete();

        return response()->json(['record' => $payrollPermissionRequest, 'message' => 'Success'], 200);
    }

    /**
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * Obtiene un listado de los permisos
    */
    public function vueList()
    {
        return response()->json(['records' => PayrollPermissionRequest::all()], 200);
    }

    /**
     * Muestra un listado de las solicitudes de permiso pendientes
     *
     * @method    vuePendingList
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     *
    */

    public function vuePendingList()
    {
        return response()->json(['records' => PayrollPermisssionRequest::where('status', 'Pendiente')->get()], 200);
    }
}
