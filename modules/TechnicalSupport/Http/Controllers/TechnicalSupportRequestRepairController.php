<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\TechnicalSupport\Models\TechnicalSupportRequestRepair;
use Modules\TechnicalSupport\Models\TechnicalSupportRepair;

class TechnicalSupportRequestRepairController extends Controller
{
    use ValidatesRequests;
    /**
     * Obtiene un listado de las solicitudes de reparaciones de bienes institucionales registradas.
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => TechnicalSupportRequestRepair::with([
            'technicalSupportRepair' => function ($query) {
                $query->with(['user' => function ($query) {
                    $query->with('profile');
                }]);
            },
            'user' => function ($query) {
                $query->with('profile');
            }
        ])->get()], 200);
    }
    /**
     * Obtiene la información de la solicitud registrada
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $id                    Identificador único de la solicitud
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueInfo($id)
    {
        $technicalSupportRequestRepair = TechnicalSupportRequestRepair::where('id', $id)->with(
            ['technicalSupportRepair', 'technicalSupportRequestRepairAssets' => function ($query) {
                $query->with('asset');
            }]
        )->first();

        return response()->json(['record' => $technicalSupportRequestRepair], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'technical_support_repair.user_id' => ['required']
        ]);

        $technicalSupportRepair = TechnicalSupportRepair::create([
            'state' => $request->input('Pendiente'),
            'user_id' => $request->input('technical_support_repair.user_id'),
            'technical_support_request_repair_id' => $request->input('id')
        ]);

        return response()->json(['result' => true, 'redirect' => route('technicalsupport.request-repair.index')], 200);
    }
}
