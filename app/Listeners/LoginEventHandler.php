<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;

class LoginEventHandler
{
    /**
     * Constructor de la clase que crea los eventos a ser monitoreados
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Registra los eventos en la autenticación de usuarios
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }
}
