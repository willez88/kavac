<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\FailedLoginAttempt;
use App\Notifications\UserBlocked;

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
        if (!$event->user->hasRole('admin')) {
            /** @var string Establece la fecha y hora en la que fue bloqueado el usuario */
            $event->user->blocked_at = date('Y-m-d H:i:s');
            $event->user->save();

            $event->user->notify(new UserBlocked($event->user));
        }

        /** Registra el evento de intento fallido */
        FailedLoginAttempt::record(
            $event->credentials['username'],
            request()->ip(),
            $event->user
        );
    }
}
