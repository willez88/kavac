<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\FailedLoginAttempt;
use App\Notifications\UserBlocked;

/*use App\Notifications\SystemNotification;
use App\User;*/

//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Queue\InteractsWithQueue;

class RecordFailedLoginAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        /** Bloquear solo si el máximo número de intentos fue alcanzado */
        $event->user->blocked_at = date('Y-m-d H:i:s');
        $event->user->save();

        $event->user->notify(new UserBlocked($event->user));

        //Enviar notificación al administrador?

        FailedLoginAttempt::record(
            $event->credentials['username'],
            request()->ip(),
            $event->user
        );
    }
}
