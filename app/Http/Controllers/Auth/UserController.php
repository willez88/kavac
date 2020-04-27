<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Profile;
use App\Models\NotificationSetting;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Notifications\UserRegistered;

/**
 * @class UserController
 * @brief Gestiona información de usuarios
 *
 * Controlador para gestionar usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UserController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Muesta todos los registros de los usuarios
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.setting-users');
    }

    /**
     * Muestra el formulario para crear un nuevo registro de usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $header = [
            'route' => 'users.store',
            'method' => 'POST',
            'role' => 'form',
        ];

        $persons = template_choices(Profile::class, ['first_name', ' ', 'last_name'], $filters = ['user_id' => null]);

        foreach ($persons as $key => $person) {
            if ($key && $key !== "0" && $profile = Profile::find($key)) {
                if ($profile->institution) {
                    $persons[$key] = $profile->institution->acronym . " - " . $persons[$key];
                }
            }
        }

        return view('auth.register', compact('header', 'persons'));
    }

    /**
     * Valida y registra un nuevo usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'staff' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:25'],
            'role' => ['required_without:permission', 'array'],
            'permission' => ['required_without:role', 'array']
        ]);

        $profile = Profile::find($request->staff);
        $password = generate_hash();
        $user = User::create([
            'name' => trim($profile->first_name . ' ' .$profile->last_name ?? ''),
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($password),
            'level' => 2
        ]);

        $profile->user_id = $user->id;
        $profile->save();

        if (isset($request->role)) {
            $user->syncRoles($request->role);
        }
        if (isset($request->permission)) {
            $user->syncPermissions($request->permission);
        }

        /**
         * TODO:
         * - colocar en cola correo a enviar
         */
        $user->notify(new UserRegistered($user, $password));
        $user->sendEmailVerificationNotification();
        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->route('access.settings.users');
    }

    /**
     * Muestra información acerca del usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $model = $user;
        $header = [
            'route' => ['users.update', $user->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('auth.profile', compact('model', 'header'));
    }

    /**
     * Muestra el formulario para actualizar información de un usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $header = [
            'route' => ['users.update', $user->id],
            'method' => 'PUT',
            'role' => 'form'
        ];
        $model = $user;
        return view('auth.register', compact('header', 'model'));
    }

    /**
     * Actualiza la información del usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if ($request->role) {
            $user->detachAllRoles();
            $user->syncRoles($request->role);
        }
        if ($request->permission) {
            $user->detachAllPermissions();
            $user->syncPermissions($request->permission);
        }
        if ($request->password) {
            $this->validate($request, [
                'password' => ['min:6', 'confirmed'],
                'password_confirmation' => ['min:6', 'required_with:password'],
                'complexity-level' => ['numeric', 'min:43', 'max:100']
            ], [
                'confirmed' => __('La contraseña no coincide con la verificación'),
                'required_with' => __('Debe confirmar la nueva contraseña'),
                'complexity-level' => __(
                    'Contraseña muy débil. Intente incorporar símbolos, letras y números, ' .
                    'en cominación con mayúsculas y minúsculas.'
                ),
            ]);

            $user->password = bcrypt($request->input('password'));
            $user->save();

            $request->session()->flash('message', ['type' => 'update']);
        } else {
            $request->session()->flash('message', ['type' => 'other', 'text' => __('No se indicaron modificaciones')]);
        }

        return redirect()->back();
    }

    /**
     * Elimina el usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return response()->json(['result' => false, 'message' => __('Usted no puede eliminarse a si mismo')], 200);
        }

        $user->delete();
        return response()->json(['record' => $user, 'message' => 'Success'], 200);
    }

    public function getRolesAndPermissions()
    {
        $roles = Role::with('permissions')->where('slug', '<>', 'user')->get();
        $permissions = Permission::with('roles')->orderBy('model_prefix')->get();
        return response()->json(['result' => true, 'roles' => $roles, 'permissions' => $permissions], 200);
    }

    /**
     * Configuración de permisos asociados a roles de usuarios
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Retorna la vista que ejecuta la acción junto con el mensaje al usuario
     */
    public function setRolesAndPermissions(Request $request)
    {
        $this->validate($request, [
            'roles_attach_permissions' => 'required|array|min:1'
        ], [
            'roles_attach_permissions.required' => __('Se requiere asignar al menos un permiso a un rol')
        ]);

        foreach (Role::all() as $r) {
            $r->detachAllPermissions();
        }

        $roleConsult = '';
        foreach ($request->roles_attach_permissions as $role_perm) {
            list($role_id, $perm_id) = explode("_", $role_perm);
            if ($roleConsult !== $role_id) {
                $role = Role::find($role_id);
                $roleConsult = $role_id;
            }
            $perm = Permission::find($perm_id);
            if (isset($role)) {
                $role->attachPermission($perm);
            }
        }

        return response()->json(['result' => true], 200);
    }

    /**
     * Muestra el formulario para la asignación de roles y permisos a usuarios
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  User   $user Modelo de Usuario
     * @return \Illuminate\View\View
     */
    public function assignAccess(User $user)
    {
        return view('admin.setting-user-access', compact('user'));
    }

    /**
     * Assigna permisos de acceso a los usuarios del sistema
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param Request $request Objeto con los datos de la petición
     */
    public function setAccess(Request $request)
    {
        $rules = [
            'user' => ['required'],
            'role' => ['required_without:permission', 'array'],
            'permission' => ['required_without:role', 'array', 'min:1']
        ];
        $messages = [
            'user.required' => __('Se requiere de un usuario para asignar roles y permisos'),
            'role.max' => __('Solo puede asignar un rol al usuario'),
            'permission.min' => __('Se requiere al menos un permiso asignado al usuario')
        ];

        $user = User::find($request->user);

        if (isset($request->role)) {
            foreach ($request->role as $role) {
                if (Role::find($role)->permissions->isEmpty()) {
                    $rules['permission'] = str_replace('required_without:role', 'required', $rules['permission']);
                    if (count($request->role) > 1) {
                        $msg = __(
                            'Uno de los roles seleccionados no tiene permisos asignados, ' .
                            'debe indicar los permisos de acceso'
                        );
                    } else {
                        $msg = __(
                            'El rol seleccionado no tiene permisos asignados, debe indicar los permisos de acceso'
                        );
                    }
                    $messages['permission.required'] = $msg;
                    break;
                }
            }
        }

        $this->validate($request, $rules, $messages);

        $user->detachAllRoles();
        $user->detachAllPermissions();

        if (isset($request->role)) {
            $user->syncRoles($request->role);
        }
        if (isset($request->permissions)) {
            $user->syncPermissions($request->permission);
        }

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->route('index');
    }

    /**
     * Muestra información del usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  User                              $user Objero que abstrae información del usuario
     * @return \Illuminate\Http\JsonResponse     Devuelve los datos asociados al usuario
     */
    public function info(User $user)
    {
        $with = [];
        if (!is_null($user->profile)) {
            $with[] = 'profile';
        }
        if (!is_null($user->roles)) {
            $with[] = 'roles';
        }
        if (!is_null($user->permissions)) {
            $with[] = 'permissions';
        }

        if (count($with) > 0) {
            $user->with($with);
        }

        return response()->json([
            'result' => true, 'user' => $user, 'permissions' => $user->getPermissions()
        ], 200);
    }

    /**
     * Muestra un listado de roles y permisos de usuario
     *
     * @method     indexRolesPermissions
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\View\View   Devuelve la vista correspondiente para mostrar el listado de roles y permisos
     */
    public function indexRolesPermissions()
    {
        return view('admin.settings-access');
    }

    /**
     * Gestiona la configuración de la cuenta de un usuario
     *
     * @method     userSettings
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\View\View           Devuelve la vista para la configuración de la cuenta de usuario
     */
    public function userSettings()
    {
        $user = auth()->user();
        $userPermissions = $user->getPermissions()->where('slug', '<>', '')->pluck('slug')->toArray();
        $notifySettings = NotificationSetting::whereIn(
            'perm_required',
            $userPermissions
        )->orWhereNull('perm_required')->get();

        $header_general_settings = [
            'route' => 'set.my.settings', 'method' => 'POST', 'role' => 'form', 'class' => 'form'
        ];
        $header_notify_settings = [
            'route' => 'set.my.notifications', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('auth.my-settings', compact(
            'user',
            'notifySettings',
            'header_notify_settings',
            'header_general_settings'
        ));
    }

    /**
     * Establece la configuración personalizada de un usuario
     *
     * @method     setUserSettings
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request            $request   Objeto con datos de la petición
     *
     * @return     \Illuminate\Http\Response     redirecciona a la página de configuración del usuario
     */
    public function setUserSettings(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->lock_screen = (!is_null($request->lock_screen));
        $user->time_lock = $request->time_lock ?? 10;
        $user->save();

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->route('my.settings');
    }

    /**
     * Gestiona la configuración de notificaciones establecida por el usuario
     *
     * @method     setMyNotifications
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @license    [description]
     *
     * @param      Request               $request    [description]
     */
    public function setMyNotifications(Request $request)
    {
        $fields = $request->all();

        if (count($fields) > 1) {
            auth()->user()->notificationSettings()->detach();
            $notifications = [];
            foreach ($fields as $keyField => $valueField) {
                if ($keyField === '_token') {
                    continue;
                }
                $notifySetting = NotificationSetting::where('slug', $keyField)->first();

                if ($notifySetting) {
                    array_push($notifications, $notifySetting->id);
                }
            }
            auth()->user()->notificationSettings()->sync($notifications);
        }

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('my.settings');
    }

    /**
     * Obtiene información acerca de la pantalla de bloqueo del sistema
     *
     * @method     getLockScreenData
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\Http\JsonResponse     Devuelve los datos correspondientes a la pantalla de bloqueo
     */
    public function getLockScreenData()
    {
        $user = auth()->user();
        return response()->json(['lock_screen' => $user->lock_screen, 'time_lock' => $user->time_lock], 200);
    }

    /**
     * Actualiza información de la pantalla de bloqueo del sistema
     *
     * @method     setLockScreenData
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      \Illuminate\Http\JsonResponse     Devuelve el resultado de la operación
     */
    public function setLockScreenData(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->lock_screen = $request->lock_screen;
        $user->save();
        return response()->json(['result' => true], 200);
    }

    /**
     * Realiza las gestiones necesarias para desbloquear la pantalla del sistema
     *
     * @method     unlockScreen
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    [description]
     *
     * @return     \Illuminate\Http\JsonResponse     Devuelve el resultado de la operación
     */
    public function unlockScreen(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        /** Verifica si la contraseña es correcta, de lo contrario retorna falso */
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['result' => false], 200);
        }

        // Agregar funcionalidad para determinar si el usuario esta autenticado (aplica para cuando expira la sesion)
        if (!auth()->check()) {
            $userCredentials = $request->only('email', 'password');
            if (!Auth::attempt($userCredentials)) {
                return response()->json(['result' => false], 200);
            }
            //$this->login($request);
        }

        /** @var boolean actualiza el campo que determina si la pantalla de bloqueo esta o no activada */
        $user->lock_screen = false;
        $user->save();

        return response()->json(['result' => true, 'new_csrf' => csrf_token()], 200);
    }
}
