<?php

namespace App\Observers;

use App\Notifications\SystemNotification;
use App\Models\NotificationSetting;

class ModelObserver
{
    /**
     * Gestiona el evento "created" de un modelo
     *
     * @method     created
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      object           $model    Objeto con información del modelo que genera el evento
     */
    public function created($model)
    {
        $this->setNotifications($model, 'created');
    }

    /**
     * Gestiona el evento "updated" de un modelo
     *
     * @method     updated
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      object           $model    Objeto con información del modelo que genera el evento
     */
    public function updated($model)
    {
        $this->setNotifications($model, 'updated');
    }

    /**
     * Gestiona el evento "deleted" de un modelo
     *
     * @method     deleted
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      object           $model    Objeto con información del modelo que genera el evento
     */
    public function deleted($model)
    {
        $this->setNotifications($model, 'deleted');
    }

    /**
     * Gestiona el evento "forceDeleted" de un modelo
     *
     * @method     forceDeleted
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      object           $model    Objeto con información del modelo que genera el evento
     */
    public function forceDeleted($model)
    {
        $this->setNotifications($model, 'forceDeleted');
    }

    /**
     * Establece las notificaciones a enviar de acuerdo a la configuración del sistema
     *
     * @method     setNotifications
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      object              $model    Objeto con información del modelo que genera el evento observado
     * @param      string              $type     Tipo de evento generado. created, updated, deleted o forceDeleted
     */
    public function setNotifications($model, $type)
    {
        /** @var string Obtiene la clase de un modelo */
        $modelClass = get_class($model);

        /** @var object Obtiene la configuración del modelo del cual enviar una notificación */
        $notifySetting = NotificationSetting::where('model', $modelClass)->first();


        if ($notifySetting) {
            /** @var string Nombre del evento o modelo a notificar */
            $eventName = $notifySetting->name;
            /** @var string Tipo de evento a notificar. creado, actualizado, eliminado o eliminado permanentemente */
            $eventType = '';
            /** @var string Descripción corta del evento a notificar */
            $event = '';

            switch ($type) {
                case 'created':
                    $eventType = __('creado(a)');
                    $event = __('un registro');
                    break;
                case 'updated':
                    $eventType = __('actualizado(a)');
                    $event = __("una actualización");
                    break;
                case 'deleted':
                    $eventType = __('eliminado(a)');
                    $event = __("una eliminación");
                    break;
                case 'forceDeleted':
                    $eventType = __('eliminado(a) permanentemente');
                    $event = __("una eliminación permanente");
                    break;
            }

            if (!empty($eventType) && !empty($event)) {
                /** @var string Título de la notificación a enviar */
                $title = "{$eventName} {$eventType}";
                /** @var string Detalle o descripción de la notificación a enviar */
                $details = "Se realizó {$event} de datos en {$eventName}";

                foreach ($notifySetting->users()->get() as $user) {
                    /** Notificación al usuario configurado para recibir notificaciones del sistema */
                    $user->notify(new SystemNotification($title, $details));
                }
            }
        }
    }
}
