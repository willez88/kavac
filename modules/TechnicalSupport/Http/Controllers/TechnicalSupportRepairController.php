<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\TechnicalSupport\Models\TechnicalSupportRepair;
use Modules\TechnicalSupport\Models\TechnicalSupportRequest;
use Modules\TechnicalSupport\Models\TechnicalSupportRequestRepair;

/**
 * @class TechnicalSupportRepairController
 * @brief Controlador de las reparaciones de bienes institucionales
 *
 * Clase que gestiona las reparaciones de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRepairController extends Controller
{
    use ValidatesRequests;
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:technicalsupport.repairs', ['only' => 'index', 'update']);
    }

    /**
     * Muestra el formulario con un listado de reparaciones de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function index()
    {
        return view('technicalsupport::repairs.list');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'user_id'                      => ['required'],
          'technical_support_request_id' => ['required']
        ]);
        $technicalSupportRequest = TechnicalSupportRequest::find($request->technical_support_request_id);
        $technicalSupportRequest->state = 'En reparación';
        $technicalSupportRequest->save();

        $technicalSupportRepair = TechnicalSupportRepair::create([
          'state'      => 'Pendiente',
          'start_date' => $request->input('start_date'),
          'end_date'   => $request->input('end_date'),
          'user_id'    => $request->input('user_id')
        ]);

        $technicalSupportRequestRepair = TechnicalSupportRequestRepair::create([
          'technical_support_repair_id'  => $technicalSupportRepair->id,
          'technical_support_request_id' => $request->input('technical_support_request_id')
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('technicalsupport.requests.index')], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Obtiene la información de la reparación registrada
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único de la reparación
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $technicalSupportRepair = TechnicalSupportRepair::where('id', $id)->with([
            'user' => function ($query) {
                $query->with('profile');
            },
            'technicalSupportRequestRepairs' => function ($query) {
                $query->with([
                    'technicalSupportDiagnostic',
                    'technicalSupportRequest' => function ($query) {
                        $query->with([
                            'asset',
                            'user' => function ($query) {
                                $query->with('profile');
                            }]);
                    }]);
            }])->first();

        return response()->json(['record' => $technicalSupportRepair], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => TechnicalSupportRepair::with([
            'user' => function ($query) {
                $query->with('profile');
            },
            'technicalSupportRequestRepairs'
        ])->get()], 200);
    }
}
