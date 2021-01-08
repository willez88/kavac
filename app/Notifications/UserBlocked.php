<?php
/** Notificaciones de la aplicación */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

/**
 * @class UserBlocked
 * @brief Notificaciones de usuario bloqueado
 *
 * Gestiona las Notificaciones de usuario bloqueado
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UserBlocked extends Notification
{
    use Queueable;

    /** @var User Objeto con información del usuario bloqueado */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        return ['mail'];
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
                    ->subject(config('app.name') . ' - ' . __('Usuario bloqueado'))
                    ->greeting(__('Advertencia, :username', ['username' => $this->user->name]))
                    ->line(
                        __('Usted a intentado ingresar al sistema demasiadas veces con datos incorrectos. ' .
                           'Por medidas de seguridad su usuario fue bloqueado, contacte a soporte para ayuda.')
                    )
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
            //
        ];
    }
}
