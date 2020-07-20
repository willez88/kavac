<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Modules\Asset\Models\AssetRequestEvent;
use Modules\Asset\Models\Asset;
use App\Repositories\UploadDocRepository;

use Modules\TechnicalSupport\Models\TechnicalSupportRequest;

/**
 * @class      AssetRequestEventController
 * @brief      Controlador de eventos en bienes institucionales solicitados
 *
 * Clase que gestiona los eventos ocurridos a los bienes institucionales solicitados
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetRequestEventController extends Controller
{
    use ValidatesRequests;

    /**
     * Muestra un listado de las solicitudes de eventos de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetRequestEvent::all()], 200);
    }

    /**
     * Valida y registra un nuevo evento
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request, UploadDocRepository $upDoc)
    {
        $this->validate($request, [
            'type'             => ['required', 'max:100'],
            'description'      => ['required'],
            'asset_request_id' => ['required'],
            'equipments'       => ['required']

        ]);
        if ($request->type == 2) {
            $this->validate($request, [
                'files.*' => ['required', 'mimes:doc,pdf,odt,docx']
            ]);
        }

        $request->equipments = json_decode($request->equipments);

        /**
         * Objeto asociado al modelo AssetRequestEvent
         *
         * @var Object $event
         */
        $event = AssetRequestEvent::create([
            'type'             => $request->input('type'),
            'description'      => $request->input('description'),
            'asset_request_id' => $request->input('asset_request_id')
        ]);
        if ($request->type == 2) {
            /** Carga los documentos en el servidor */
            if ($request->files) {
                foreach ($request->file('files') as $file) {
                    $upDoc->uploadDoc(
                        $file,
                        'documents',
                        AssetRequestEvent::class,
                        $event->id,
                        null,
                        false,
                        false,
                        true
                    );
                }
            }
        }
        foreach ($request->equipments as $equipment) {
            $asset = Asset::find($equipment);
            /** Si se selecciona la opción averiado */
            if ($request->type == 1) {
                $asset->asset_condition_id = 4;
                $asset->save();
                $technicalSupportRequest = TechnicalSupportRequest::create([
                    'state'       => 'Pendiente',
                    'description' => $request->input('description'),
                    'user_id'     => Auth::id(),
                    'asset_id'    => $asset->id,
                ]);
            }
            /** Falta agregar para el caso de perdido */
        }
        return response()->json(['record' => $event, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de las solicitudes de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único del evento
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
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
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer                          $id         Identificador único del evento
     * @return    \Illuminate\Http\JsonResponse                    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        $event = AssetRequestEvent::find($id);
        $event->delete();
        return response()->json(['message' => 'Success'], 200);
    }
}
