<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\TechnicalSupport\Models\TechnicalSupportRepair;
use Modules\TechnicalSupport\Models\TechnicalSupportRequest;

class TechnicalSupportRequestController extends Controller
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
      //$this->middleware('permission:technicalsupport.request', ['only' => 'index', 'vueInfo']);
    }

    /**
     * Obtiene un listado de las solicitudes de reparaciones de bienes institucionales registradas.
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return view('technicalsupport::requests.list');
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
        $technicalSupportRequest = TechnicalSupportRequest::where('id', $id)->with([
            'asset' => function ($query) {
                $query->with([
                    'assetType', 'assetCategory', 'assetSubcategory', 'assetSpecificCategory',
                    'assetCondition', 'assetAcquisitionType', 'assetStatus', 'assetUseFunction'
                ]);
            },
            'user' => function ($query) {
                $query->with('profile');
            },
            'technicalSupportRequestRepair' => function ($query) {
                $query->with('technicalSupportRepair');
            }
        ])->first();

        return response()->json(['record' => $technicalSupportRequest], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => TechnicalSupportRequest::with([
            'asset',
            'user' => function ($query) {
                $query->with('profile');
            }
        ])->get()], 200);
    }
}
