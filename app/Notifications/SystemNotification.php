<?php
/** Notificaciones de la aplicación */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

/**
 * @class SystemNotification
 * @brief Notificaciones del sistema
 *
 * Gestiona las Notificaciones del sistema
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SystemNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    /** @var string Título de la notificación */
    public $title;
    /** @var string Detalles de la notificación */
    public $details;
    /** @var string Fecha y hora en que se realiza la notificación */
    public $currentTimestamp;

    /**
     * Create a new notification instance.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct($title, $details, $currentTimestamp = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->currentTimestamp = $currentTimestamp ?? \Carbon\Carbon::now()->toDateString();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @method  via
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @method  toArray
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @method  toDatabase
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @method    toBroadcast
     *
     * @param     mixed  $notifiable
     *
     * @return    array
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ]);
    }
}
