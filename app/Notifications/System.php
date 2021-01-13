<?php
/** Notificaciones de la aplicación */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

/**
 * @class System
 * @brief Notificaciones del sistema
 *
 * Gestiona las Notificaciones del sistema
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class System extends Notification //implements ShouldQueue
{
    use Queueable;

    /** @var string Título de la notificación */
    protected $title;
    /** @var string Módulo que genera la notificación */
    protected $module;
    /** @var string Descripción de la notificación */
    protected $description;
    /** @var string Dirección de correo del usuario a notificar */
    protected $notifyToEmail;

    /**
     * Create a new notification instance.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct($title, $module, $description, $notifyToEmail = false)
    {
        $this->title = $title;
        $this->module = $module;
        $this->description = $description;
        $this->notifyToEmail = $notifyToEmail;
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
        return $this->notifyToEmail ? ['mail'] : ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @method  toMail
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($this->title)
                    ->line($this->title)
                    ->line($this->description);
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
            'module' => $this->module,
            'description' => $this->description,
        ];
    }

    /**
     * Get the array representation of the notification
     *
     * @method  toDatabase
     *
     * @param   mixed $notifiable
     *
     * @return  array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'module' => $this->module,
            'description' => $this->description,
        ];
    }

    /**
     * Get the array representation of the notification
     *
     * @method  toBroadcast
     *
     * @param   mixed $notifiable
     *
     * @return  \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'module' => $this->module ?? '',
            'description' => $this->description,
        ]);
    }
}
