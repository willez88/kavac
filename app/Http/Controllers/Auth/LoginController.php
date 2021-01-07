<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Captcha;

/**
 * @class LoginController
 * @brief Gestiona información de autenticación
 *
 * Controlador para gestionar la autenticación de usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
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
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->remainAttempts = $this->maxAttempts - $this->limiter()->attempts($this->throttleKey(request()));
    }

    /**
     * Gestiona una petición de acceso a la aplicación.
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
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => ['required', 'exists:users'],
            'password' => [
                'required', 'string', function ($attribute, $value, $fail) use ($request) {
                    $user = User::where('username', $request->username)->first();
                    /** Valida que la contraseña coincida, en caso contrario notifica al usuario */
                    if ($user!== null && !Hash::check($value, $user->password)) {
                        $fail('La contraseña es incorrecta');
                    }
                }
            ],
            'captcha' => ['required', 'captcha']
        ], [
            $this->username().'.exists' => 'El usuario no existe'
        ]);
    }

    /**
     * Obtiene el campo usado como nombre de usuario para el acceso a la aplicación, usado por el controlador.
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
