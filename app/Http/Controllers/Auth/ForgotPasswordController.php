<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * @class ForgotPasswordController
 * @brief Gestiona el olvido de contraseña
 *
 * Controlador para gestionar la recuperación de contraseñas de usuario
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Crea una nueva instancia del controlador.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
