<?php

/** Middlewares base de la aplicación */
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * @class TrimStrings
 * @brief Gestiona los middleware para eliminar espacios de una cadena de texto
 *
 * Gestiona los middleware para eliminar espacios de una cadena de texto
 */
class TrimStrings extends Middleware
{
    /**
     * Los nombres de los atributos a los que no deben eliminarse espacios.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
