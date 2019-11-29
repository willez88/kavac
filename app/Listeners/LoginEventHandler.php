<?php

/** Gestión de eventos del sistema */
namespace App\Listeners;

//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Auth\Events\Login;

/**
 * @class LoginEventHandler
 * @brief Gestiona eventos en la autenticación de usuarios
 *
 * Gestiona los eventos generados en la autenticación de usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }
}
