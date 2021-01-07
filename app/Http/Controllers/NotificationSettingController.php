<?php
/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;

/**
 * @class NotificationSettingController
 * @brief Gestiona información para la configuración de notificaciones del sistema
 *
 * Controlador para gestionar configuración de notificaciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class NotificationSettingController extends Controller
{
    /**
     * Listado de las configuraciones de notificaciones registradas
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function index()
    {
        //
    }

    /**
     * Muestra un formulario para el registro de configuración de notificaciones
     *
     * @method    create
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function create()
    {
        //
    }

    /**
     * Registra una nueva configuración de notificaciones
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra información de una configuración de notificación
     *
     * @method    show
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     NotificationSetting    $notificationSetting    Objeto con los datos de la configuración de
     *                                                           notificación a mostrar
     */
    public function show(NotificationSetting $notificationSetting)
    {
        //
    }

    /**
     * Muestra un formulario con información de una configuración de notificaciones a actualizar
     *
     * @method    edit
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     NotificationSetting    $notificationSetting    Objeto con información de la configuración a actualizar
     */
    public function edit(NotificationSetting $notificationSetting)
    {
        //
    }

    /**
     * Actualiza información sobre una configuración de notificaciones
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request                $request                Objeto con información de la petición
     * @param     NotificationSetting    $notificationSetting    Objeto con información de la configuración a actualizar
     */
    public function update(Request $request, NotificationSetting $notificationSetting)
    {
        //
    }

    /**
     * Elimina una configuración de notificaciones
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     NotificationSetting    $notificationSetting    Objeto con información de la configuración a eliminar
     */
    public function destroy(NotificationSetting $notificationSetting)
    {
        //
    }
}
