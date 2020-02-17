<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SystemNotification;

class SystemNotificationController extends Controller
{
    /** @var object|array Objeto o arreglo con información del o los usuarios a los cuales enviar una notificación */
    protected $toUser;

    /**
     * Método constructor del controlador de notificaciones del sistema
     *
     * @method     __construct
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct($toUser)
    {
        $this->toUser = $toUser;
    }

    /**
     * Método que envía notificaciones del sistema a usuarios
     *
     * @method     send
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    Objeto con información de la petición
     *
     * @return     json             Json con información sobre el resultado del envío de la notificación
     */
    public function send(Request $request)
    {
        if (is_array($this->toUser)) {
            foreach ($this->toUser as $toUser) {
                $toUser->notify(new SystemNotification('Notificación del sistema', $request->details));
            }
        } else {
            $this->toUser->notify(new SystemNotification('Notificación del sistema', $request->details));
        }

        return response()->json(['result' => true, 'message' => 'Success'], 200);
    }
}
