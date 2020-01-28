<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class UserRegistered extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;
    public $password;
    public $notifyTitle;
    public $notifyDescription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->notifyTitle = __('Modificar contraseña');
        $this->notifyDescription = __('Bienvenido al sistema, recuerde modificar su contraseña en el primer acceso');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject(__('Registro de usuario') . ' - ' . config('app.name'))
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->notifyTitle,
            'module' => null,
            'description' => $this->notifyDescription,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->notifyTitle,
            'module' => null,
            'description' => $this->notifyDescription,
        ];
    }
}
