<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Payroll\Models\PayrollVacationRequest;
use App\Models\Institution;

/**
 * @class      PayrollVacationRequestController
 * @brief      Controlador de solicitudes vacacionales
 *
 * Clase que gestiona las solicitudes vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
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
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
        ];
    }

    /**
     * Muestra un listado de las solicitudes vacacionales registradas
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
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Renderable
     */
    public function create()
    {
        return view('payroll::requests.vacations.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy()
    {
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
        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        return response()->json(
            ['records' => PayrollVacationRequest::where('institution_id', $institution->id)->get()],
            200
        );
    }
}
