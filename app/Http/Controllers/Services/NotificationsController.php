<?php
/** Controladores para la gestión de servicios generales del sistema */
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;

/**
 * @class NotificationsController
 * @brief Gestiona información de las notificaciones
 *
 * Controlador para gestionar las notificaciones de los usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse JSON con los datos de las notificaciones no leídas
     */
    public function getUnreaded()
    {
        $notifications = auth()->user()->notifications()->whereNull('read_at')->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }

    /**
     * Obtiene las notificaciones leídas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse JSON con los datos de las notificaciones leídas
     */
    public function getReaded()
    {
        $notifications = auth()->user()->notifications()->whereNotNull('read_at')->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }

    /**
     * Obtiene todas las notificaciones registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse JSON con los datos de todas las notificaciones registradas
     */
    public function getAll()
    {
        $notifications = auth()->user()->notifications()->get();
        return response()->json(['result' => true, 'notifications' => $notifications], 200);
    }
}
