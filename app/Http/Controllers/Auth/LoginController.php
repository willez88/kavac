<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\User;

use Captcha;

/**
 * @class LoginController
 * @brief Gestiona información de autenticación
 *
 * Controlador para gestionar la autenticación de usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Número máximo de intentos fallidos al tratar de autenticarse en la aplicación
     *
     * @var    integer
     */
    protected $maxAttempts = 3;

    /**
     * Tiempo establecido para volver a intentar el acceso al sistema después de varios intentos fallidos
     *
     * @var    integer
     */
    protected $decayMinutes = 300;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where('username', $request->username)->firstOrFail();
        if ($user && !is_null($user->blocked_at)) {
            return $this->sendLockedAccountResponse($request);
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => ['required'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'captcha']
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->lock_screen = false;
        $user->save();
    }

    /**
     * Refresh the captcha image
     */
    public function refreshCaptcha()
    {
        return Captcha::Img();
    }

    /**
     * Obtiene la instancia de la petición del usuario bloqueado.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLockedAccountResponse(Request $request)
    {
        return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors([
            $this->username() => $this->getLockedAccountMessage(),
        ]);
    }

    /**
     * Obtiene el mensaje a mostrar para la cuenta bloqueada.
     *
     * @return string
     */
    protected function getLockedAccountMessage()
    {
        return Lang::has('auth.locked')
               ? Lang::get('auth.locked')
               : 'Tú cuenta esta bloqueada. Por favor contacte a soporte por ayuda.';
    }
}
