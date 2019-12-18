<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetRequestEvent;
use Modules\Asset\Models\Asset;
use App\Models\Document;
use App\Repositories\UploadDocRepository;

/**
 * @class AssetRequestEventController
 * @brief Controlador de eventos en bienes institucionales solicitados
 *
 * Clase que gestiona los eventos ocurridos a los bienes institucionales solicitados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
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
    public function store(Request $request, UploadDocRepository $up)
    {
        $this->validate($request, [
            'type'             => ['required', 'max:100'],
            'description'      => ['required'],
            'asset_request_id' => ['required'],
            'equipments'       => ['required']

        ]);
        if ($request->type == 2) {
            $this->validate($request, [
                'file' => ['required', 'mimes:doc,pdf,odt,docx']
            ]);
            $doc = null;
            if ($request->file('file')) {
                /** Gestiona la carga del archivo del documento al servidor y la asigna al campo correspondiente */
                if ($up->uploadDoc($request->file('file'), 'documents')) {
                    $doc = $up->getDocStored()->id;
                }
            }
            $document = Document::find($doc);
        }
        $request->equipments = json_decode($request->equipments);

        $event = AssetRequestEvent::create([
            'type'             => $request->input('type'),
            'document_id'      => $document->id ?? null,
            'description'      => $request->input('description'),
            'asset_request_id' => $request->input('asset_request_id')
        ]);
        foreach ($request->equipments as $equipment) {
            $asset = Asset::find($equipment);
            /** Si se selecciona la opción averiado */
            if ($request->type == 1) {
                $asset->asset_condition_id = 4;
                $asset->save();
            }
            /** Falta agregar para el caso de perdido */
        }
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
    public function update(Request $request, $id)
    {
        $event = AssetRequestEvent::find($id);
        $this->validate($request, [
            'type' => ['required', 'max:100'],
            'description' => ['required'],
            'asset_request_id' => ['required']
        ]);

        $event->type = $request->input('type');
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
    public function destroy($id)
    {
        $event = AssetRequestEvent::find($id);
        $event->delete();
        return response()->json(['message' => 'Success'], 200);
    }
}
