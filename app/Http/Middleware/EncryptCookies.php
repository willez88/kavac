<?php

/** Middlewares base de la aplicación */
namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * @class EncryptCookies
 * @brief Gestiona los middleware para en cifrado de cookies
 *
 * Gestiona los middleware para en cifrado de cookies
 */
class EncryptCookies extends Middleware
{
    /**
     * Los nombres de las cookies que no deben cifrarse.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
