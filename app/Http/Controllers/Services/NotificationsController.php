<?php
/** Controladores para la gestión de servicios generales del sistema */
namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

/**
 * @class NotificationsController
 * @brief Gestiona información de las notificaciones
 *
 * Controlador para gestionar las notificaciones de los usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class NotificationsController extends Controller
{
    /**
     * Muestra las notificaciones del sistema
     *
     * @method    show
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    View    Vista con las notificaciones
     */
    public function show()
    {
        return view('auth.notifications');
    }

    /**
     * Obtiene las notificaciones no leídas
     *
     * @method  getUnreaded
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse JSON con los datos de las notificaciones no leídas
     */
    public function getUnreaded()
    {
        /** @var Notification Objeto con las notificaciones no leídas del usuario */
        $notifications = auth()->user()->notifications()->whereNull('read_at')->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }

    /**
     * Obtiene las notificaciones leídas
     *
     * @method  getReaded
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse JSON con los datos de las notificaciones leídas
     */
    public function getReaded()
    {
        /** @var Notification Objeto con las notificaciones leídas del usuario */
        $notifications = auth()->user()->notifications()->whereNotNull('read_at')->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }

    /**
     * Obtiene todas las notificaciones registradas
     *
     * @method  getAll
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse JSON con los datos de todas las notificaciones registradas
     */
    public function getAll()
    {
        /** @var Notification Objeto con todas las notificaciones del usuario */
        $notifications = auth()->user()->notifications()->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }

    /**
     * Marca un mensaje de notificación como leído o no leído según la solicitud del usuarios
     *
     * @method    mark
     *
     * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Datos de la petición
     *
     * @return    JsonResponse
     */
    public function mark(Request $request)
    {
        $readAt = Carbon::now();
        $markAs = ($request->asRead) ? 'read' : 'unread';
        
        if (isset($request->multipleMark) && is_array($request->multipleMark) && count($request->multipleMark) > 0) {
            $notifications = auth()->user()->notifications()->whereIn('id', $request->multipleMark);
            if ($markAs === 'unread') {
                $notifications = $notifications->whereNotNull('read_at')->get();
                $readAt = null;
            } else {
                $notifications = $notifications->whereNull('read_at')->get();
            }
            foreach ($notifications as $notification) {
                $notification->update([
                    'read_at' => $readAt
                ]);
            }

            return response()->json(['result' => true], 200);
        }

        $notification = auth()->user()->notifications()->find($request->notifyId);

        $notification->update([
            'read_at' => ($notification && $markAs === 'read') ? $readAt : null
        ]);

        return response()->json([
            'result' => true, 'markAs' => $markAs, 'notifications' => auth()->user()->unreadNotifications
        ], 200);
    }
}
