<?php

/** Middlewares base de la aplicación */
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

/**
 * @class CheckForMaintenanceMode
 * @brief Gestiona los middleware de chequeo para el modo en mantenimiento
 *
 * Gestiona los middleware de chequeo para el modo en mantenimiento
 */
class CheckForMaintenanceMode extends Middleware
{
    /**
     * Las URL que deben ser accesibles mientras el modo de mantenimiento está habilitado.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
