<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Models\User;

use Captcha;

/**
 * @class LoginController
 * @brief Gestiona información de autenticación
 *
 * Controlador para gestionar la autenticación de usuarios
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
     * Intentos fallidos restantes
     *
     * @var    integer
     */
    protected $remainAttempts;

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
     * Crea una nueva instancia del controlador.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->remainAttempts = $this->maxAttempts - $this->limiter()->attempts($this->throttleKey(request()));
    }

    /**
     * Muestra el formulario de autenticación de usuario
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view(env('AUTH_VIEW', 'auth.login'));
    }

    /**
     * Gestiona una petición de acceso a la aplicación.
     *
     * @method  login
     *
     * @param  Request  $request
     *
     * @return RedirectResponse|Response|JsonResponse
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        /** @var User Objeto con información del usuario a autenticar */
        $user = User::where('username', $request->username)->firstOrFail();
        if ($user !== null && !is_null($user->blocked_at)) {
            return $this->sendLockedAccountResponse($request);
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            /** elimina la cantidad de intentos fallidos del usuario y se procede al bloqueo del mismo */
            $this->clearLoginAttempts($request);

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
     * Obtiene la instancia de peticiones de acceso fallidas.
     *
     * @method sendFailedLoginResponse
     *
     * @param  Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed', ['attempts' => $this->remainAttempts])],
        ]);
    }

    /**
     * Valida la petición de acceso del usuario.
     *
     * @method  validateLogin
     *
     * @param  Request  $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => ['required', 'exists:users'],
            'password' => [
                'required', 'string'
            ],
            'captcha' => ['required', 'captcha']
        ], [
            $this->username().'.exists' => 'Estas credenciales no coinciden con nuestros registros'
        ]);
    }

    /**
     * Obtiene el campo usado como nombre de usuario para el acceso a la aplicación, usado por el controlador.
     *
     * @method  username
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * El usuario ha sido autenticado en la aplicación.
     *
     * @method  authenticated
     *
     * @param  Request  $request
     * @param  mixed  $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->lock_screen = false;
        $user->save();
    }

    /**
     * Actualiza la imagen del captcha
     *
     * @method    refreshCaptcha
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    object            Objeto con los datos de la nueva imagen generada
     */
    public function refreshCaptcha()
    {
        return Captcha::Img();
    }

    /**
     * Obtiene la instancia de la petición del usuario bloqueado.
     *
     * @method  sendLockedAccountResponse
     *
     * @param Request  $request
     *
     * @return Response
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
     * @method  getLockedAccountMessage
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
