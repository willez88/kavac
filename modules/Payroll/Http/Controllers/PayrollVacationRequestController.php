<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollVacationRequest;
use Modules\Payroll\Models\PayrollVacationPolicy;
use Modules\Payroll\Models\PayrollStaff;
use Modules\Payroll\Models\Institution;
use App\Models\CodeSetting;

/**
 * @class      PayrollVacationRequestController
 * @brief      Controlador de solicitudes vacacionales
 *
 * Clase que gestiona las solicitudes vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollVacationRequestController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author     Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.vacation-requests.list',   ['only' => ['index', 'vueList']]);
        //$this->middleware('permission:payroll.vacation-requests.create', ['only' => ['create', 'store']]);
        //$this->middleware('permission:payroll.vacation-requests.edit',   ['only' => ['edit', 'update']]);
        //$this->middleware('permission:payroll.vacation-requests.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'payroll_staff_id'     => ['required'],
            'vacation_period_year' => ['required'],
            'days_requested'       => ['required'],
            'start_date'           => ['required'],
            'end_date'             => ['required']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'payroll_staff_id.required'     => 'El campo trabajador es obligatorio.',
            'vacation_period_year.required' => 'El campo año del período vacacional es obligatorio.',
            'days_requested.required'       => 'El campo días solicitados es obligatorio.',
            'start_date.required'           => 'El campo fecha de inicio de las vacaciones es obligatorio.',
            'end_date.required'             => 'El campo fecha de culminación de las vacaciones es obligatorio.'
        ];
    }

    /**
     * Muestra un listado de las solicitudes vacacionales registradas
     *
     * @method    index
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Renderable
     */
    public function index()
    {
        return view('payroll::requests.vacations.index');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud vacacional
     *
     * @method    create
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Renderable
     */
    public function create()
    {
        return view('payroll::requests.vacations.create-edit');
    }

    /**
     * Valida y registra una nueva solicitud de vacaciones
     *
     * @method    store
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        $codeSetting = CodeSetting::where('table', 'payroll_vacation_requests')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
            ]);
            return response()->json(['result' => false, 'redirect' => route('payroll.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        /**
         * Objeto asociado al modelo PayrollVacationRequest
         *
         * @var Object $payrollVacationRequest
         */
        $payrollVacationRequest = PayrollVacationRequest::create([
            'code'                 => $code,
            'status'               => 'pending',
            'days_requested'       => $request->input('days_requested'),
            'vacation_period_year' => $request->input('vacation_period_year'),
            'start_date'           => $request->input('start_date'),
            'end_date'             => $request->input('end_date'),
            'payroll_staff_id'     => $request->input('payroll_staff_id'),
            'institution_id'       => $institution->id
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.vacation-requests.index')], 200);
    }

    /**
     * Muestra los datos de la información de la solicitud de vacaciones seleccionada
     *
     * @method    show
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer        $id    Identificador único de la solicitud de vacaciones
     *
     * @return    Renderable
     */
    public function show($id)
    {
        $payrollVacationRequest = PayrollVacationRequest::find($id);
        return response()->json(['record' => $payrollVacationRequest], 200);
    }

    /**
     * Muestra el formulario para actualizar la información de una solicitud vacacional
     *
     * @method    edit
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer        $id    Identificador único del registro de solicitud de vacaciones
     *
     * @return    Renderable
     */
    public function edit($id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationRequest
         * @var    Object    $payrollVacationRequest
         */
        $payrollVacationRequest = PayrollVacationRequest::find($id);
        return view('payroll::requests.vacations.create-edit', compact('payrollVacationRequest'));
    }

    /**
     * Actualiza la información de la solicitud de vacaciones
     *
     * @method    update
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                     $id         Identificador único asociado a la solicitud de vacaciones
     *
     * @param     \Illuminate\Http\Request    $request    Datos de la petición
     *
     * @return    Renderable
     */
    public function update(Request $request, $id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationRequest
         * @var    Object    $payrollVacationRequest
         */


        $payrollVacationRequest = PayrollVacationRequest::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        $payrollVacationRequest->update([
            'status'               => $payrollVacationRequest->status,
            'days_requested'       => $request->input('days_requested'),
            'vacation_period_year' => $request->input('vacation_period_year'),
            'start_date'           => $request->input('start_date'),
            'end_date'             => $request->input('end_date'),
            'payroll_staff_id'     => $request->input('payroll_staff_id'),
            'institution_id'       => $institution->id
        ]);

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.vacation-requests.index')], 200);
    }

    /**
     * Elimina una solicitud de vacaciones
     *
     * @method    destroy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer        $id    Identificador único de la solicitud de vacaciones a eliminar
     *
     * @return    Renderable
     */
    public function destroy($id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationRequest
         * @var    Object    $payrollVacationRequest
         */
        $payrollVacationRequest = PayrollVacationRequest::find($id);
        $payrollVacationRequest->delete();

        return response()->json(['record' => $payrollVacationRequest, 'message' => 'Success'], 200);
    }

    /**
     * Muestra un listado de las solicitudes vacacionales registradas
     *
     * @method    vueList
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList()
    {
        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        if ($user->hasRole('admin')) {
            $records = PayrollVacationRequest::where('institution_id', $institution->id)
                ->where('status', 'approved')
                ->get();
        } else {
            $records = [];
        }
        return response()->json(['records' => $records], 200);
    }

    /**
     * Muestra un listado de las solicitudes vacacionales pendientes registradas
     *
     * @method    vuePendingList
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vuePendingList()
    {
        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        if ($user->hasRole('admin')) {
            $records = PayrollVacationRequest::where('institution_id', $institution->id)
                ->where('status', 'pending')
                ->get();
        } else {
            $records = [];
        }
        return response()->json(['records' => $records], 200);
    }

    /**
     * Muestra el listado de solicitudes de vacaciones según el trabajador seleccionado
     *
     * @method    getVacationRequests
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único del trabajador registrado
     *
     * @return    \Illuminate\Http\JsonResponse           Objeto con los registros a mostrar
     */
    public function getVacationRequests($staff_id)
    {
        $payrollVacationRequest = PayrollVacationRequest::where('payroll_staff_id', $staff_id)
            ->whereIn('status', ['pending', 'approved'])->get();
        return response()->json(['records' => $payrollVacationRequest], 200);
    }

    /**
     * Actualiza la información de la solicitud de vacaciones
     *
     * @method    review
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                     $id         Identificador único asociado a la solicitud de vacaciones
     *
     * @param     \Illuminate\Http\Request    $request    Datos de la petición
     *
     * @return    Renderable
     */
    public function review(Request $request, $id)
    {
        /**
         * Objeto asociado al modelo PayrollVacationRequest
         * @var    Object    $payrollVacationRequest
         */
        $payrollVacationRequest = PayrollVacationRequest::find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        $payrollVacationRequest->update([
            'status'               => $request->input('status'),
            'status_parameters'    => json_encode($request->input('status_parameters')),
        ]);

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('payroll.vacation-requests.index')], 200);
    }
}
