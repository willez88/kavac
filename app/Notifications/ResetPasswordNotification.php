<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    use Queueable;

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(config('app.name') . ' - ' . __('Solicitud para reinicio de contraseña'))
            ->line(
                __('Estás recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de
                contraseña para tu cuenta.')
            )->action(__('Reestablecer contraseña'), $url)
            ->line(
                __('Este enlace, para el reestablecimiento de su contraseña, caducará en ') .
                config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . __(' minutos.')
            )->line(__('Si no solicitó un restablecimiento de contraseña, no es necesario realizar ninguna otra acción.'));
    }
}
