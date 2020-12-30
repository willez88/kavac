<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(config('app.name') . ' - ' . __('Verificar usuario'))
            ->line(__('Haga clic en el botón de abajo para verificar su usuario.'))
            ->action(__('Verificar usuario'), $url)
            ->line(__('Omita este mensaje si no le fue asignada una cuenta en el sistema.'));
    }
}
