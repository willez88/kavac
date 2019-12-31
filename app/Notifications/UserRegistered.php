<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
                    ->subject('Registro de usuario - ' . config('app.name'))
                    ->greeting('Bienvenido, ' . $this->user->name)
                    ->line('Se ha registrado un usuario en la plataforma con las siguientes credenciales de acceso:')
                    ->line('**Usuario:** ' . $this->user->username)
                    ->line('**Contraseña:** ' . $this->password)
                    ->line('Para acceder pulse sobre el botón a continuación')
                    ->action('Acceso', route('index'))
                    ->line(
                        'Este correo es enviado de manera automática por la aplicación y no esta siendo monitoreado. ' .
                        'Por favor no responda a este correo!'
                    );
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
            'title' => 'Modificar contraseña',
            'module' => null,
            'description' => 'Bienvenido al sistema, recuerde modificar su contraseña en el primer acceso',
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Modificar contraseña',
            'module' => null,
            'description' => 'Bienvenido al sistema, recuerde modificar su contraseña en el primer acceso',
        ];
    }
}
