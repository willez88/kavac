<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetRequestEvent;

/**
 * @class AssetRequestEventController
 * @brief Controlador de eventos en bienes institucionales solicitados
 * 
 * Clase que gestiona los eventos ocurridos a los bienes institucionales solicitados
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetRequestEventController extends Controller
{
    use ValidatesRequests;

    /**
     * Muestra un listado de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetRequestEvent::all()], 200);
    }

    /**
     * Valida y registra un nuevo evento
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_id' => 'required|max:100',
            'description' => 'required',
            'asset_request_id' => 'required'
        ]);
    
        $event = AssetRequestEvent::create([
            'type' => $request->input('type_id'),
            'description' => $request->input('description'),
            'asset_request_id' => $request->input('asset_request_id')
        ]);

        return response()->json(['record' => $event, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de las solicitudes de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request             Datos de la petición
     * @param  Modules\Asset\Models\AssetRequestEvent $event  Datos del evento
     * @return \Illuminate\Http\JsonResponse                  Objeto con los registros a mostrar
     */
    public function update(Request $request, AssetRequestEvent $event)
    {
        $this->validate($request, [
            'type_id' => 'required|max:100',
            'description' => 'required',
            'asset_request_id' => 'required'
        ]);

        $event->type_id = $request->input('type_id');
        $event->description = $request->input('description');
        $event->asset_request_id = $request->input('asset_request_id');
        $event->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un evento
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Modules\Asset\Models\AssetRequestEvent $event    Datos del evento
     * @return \Illuminate\Http\JsonResponse                    Objeto con los registros a mostrar
     */
    public function destroy(AssetRequestEvent $event)
    {
        $event->delete();
        return response()->json(['message' => 'Success'], 200);
    }
}
