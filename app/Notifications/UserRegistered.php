<?php
/** Notificaciones de la aplicación */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

/**
 * @class UserRegistered
 * @brief Notificaciones de usuario registrado
 *
 * Gestiona las Notificaciones de usuario registrado
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UserRegistered extends Notification //implements ShouldQueue
{
    use Queueable;

    /** @var User Objeto con información del usuario registrado */
    public $user;
    /** @var string Contraseña generada del usuario registrado  */
    public $password;
    /** @var string Título de la notificación */
    public $notifyTitle;
    /** @var string Mensaje de la notificación */
    public $notifyMessage;

    /**
     * Create a new notification instance.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->notifyTitle = __('Modificar contraseña');
        $this->notifyMessage = __('Bienvenido al sistema, recuerde modificar su contraseña en el primer acceso');
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
        return ['mail', 'database'];
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
                    ->subject(config('app.name') . ' - ' . __('Registro de usuario'))
                    ->greeting(__('Bienvenido, :username', ['username' => $this->user->name]))
                    ->line(
                        __('Se ha registrado un usuario en la plataforma con las siguientes credenciales de acceso:')
                    )
                    ->line(__('**Usuario:** :username', ['username' => $this->user->username]))
                    ->line(__('**Contraseña:** :password', ['password' => $this->password]))
                    ->line(__('Para acceder pulse sobre el botón a continuación'))
                    ->action(__('Acceso'), route('index'))
                    ->line(__(
                        'Este correo es enviado de manera automática por la aplicación y no esta siendo monitoreado. ' .
                        'Por favor no responda a este correo!'
                    ));
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
            'title' => $this->notifyTitle,
            'module' => null,
            'message' => $this->notifyMessage,
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
            'title' => $this->notifyTitle,
            'module' => null,
            'message' => $this->notifyMessage,
        ];
    }
}
