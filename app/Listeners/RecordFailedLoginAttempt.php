<?php
/** Gestión de eventos del sistema */
namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\FailedLoginAttempt;
use App\Notifications\UserBlocked;
use App\Models\User;

/**
 * @class RecordFailedLoginAttempt
 * @brief Gestiona eventos de los intentos fallidos de acceso a la aplicación
 *
 * Gestiona los eventos generados de los intentos fallidos de acceso a la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class RecordFailedLoginAttempt
{
    /**
     * Crea el detector de eventos.
     *
     * @method  __contruct
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Gestiona el evento.
     *
     * @method  handle
     *
     * @param  Failed  $event
     *
     * @return void
     */
    public function handle(Failed $event)
    {
        /** @var string Establece la fecha y hora en la que fue bloqueado el usuario */
        $event->user->blocked_at = date('Y-m-d H:i:s');
        $event->user->save();

        $event->user->notify(new UserBlocked(User::find($event->user->id)));

        /** Registra el evento de intento fallido */
        FailedLoginAttempt::record(
            $event->credentials['username'],
            request()->ip(),
            $event->user
        );
    }
}
