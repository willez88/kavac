<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\NotificationSetting;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Notifications\UserRegistered;
use Carbon\Carbon;

/**
 * @class UserController
 * @brief Gestiona información de usuarios
 *
 * Controlador para gestionar usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UserController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Listado de todos los registros de los usuarios
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.setting-users');
    }

    /**
     * Muestra el formulario para crear un nuevo registro de usuario
     *
     * @method  create
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
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
     * Registra un nuevo usuario
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required_without:staff'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:25', 'unique:users'],
            'role' => ['required_without:permission', 'array'],
            'permission' => ['required_without:role', 'array']
        ], [
            'first_name.required_without' => 'El campo nombre es requerido cuando no se ha seleccionado un empleado'
        ]);

        if ($request->staff) {
            /** @var Profile Objeto con información del perfil del usuario */
            $profile = Profile::find($request->staff);
        }

        /** @var string Hash con una contraseña generada aleatoriamente */
        $password = generate_hash();
        /** @var User Objeto con información del usuario registrado */
        $user = User::create([
            'name' => (!isset($profile))?$request->first_name:trim($profile->first_name . ' ' .$profile->last_name ?? ''),
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($password),
            'level' => 2
        ]);

        if (!$request->staff) {
            /** @var Profile Instancia al modelo de perfil de usuario */
            $profile = new Profile;
            $profile->first_name = $request->first_name;
        }

        $profile->user_id = $user->id;
        $profile->save();

        if (isset($request->role)) {
            // Asigna los roles al usuario
            $user->syncRoles($request->role);
        }
        if (isset($request->permission)) {
            // Asigna los permisos al usuario
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
     * @method  show
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  User  $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        /** @var User Objeto con información del usuario */
        $model = $user;
        /** @var array Atributos del formulario para la gestión de usuarios */
        $header = [
            'route' => ['users.update', $user->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('auth.profile', compact('model', 'header'));
    }

    /**
     * Muestra el formulario para actualizar información de un usuario
     *
     * @method  edit
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  User  $user
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        /** @var array Arreglo con atributos del formulario para la actualización de datos */
        $header = [
            'route' => ['users.update', $user->id],
            'method' => 'PUT',
            'role' => 'form'
        ];
        /** @var User Objeto con información del usuario */
        $model = $user;
        return view('auth.register', compact('header', 'model'));
    }

    /**
     * Actualiza la información del usuario
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request
     * @param  User  $user
     *
     * @return RedirectResponse
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
		/*'complexity-level' => ['numeric', 'min:43', 'max:100']*/
            ], [
                'confirmed' => __('La contraseña no coincide con la verificación'),
                'required_with' => __('Debe confirmar la nueva contraseña'),
               /* 'complexity-level' => __(
                    'Contraseña muy débil. Intente incorporar símbolos, letras y números, ' .
                    'en cominación con mayúsculas y minúsculas.'
	       ),*/
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
     * Elimina un usuario
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  User  $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return response()->json(['result' => false, 'message' => __('Usted no puede eliminarse a si mismo')], 200);
        }

        $user->delete();
        session()->flash('message', ['type' => 'destroy']);
        return response()->json(['result' => true, 'record' => $user, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los roles y permisos disponibles
     *
     * @method    getRolesAndPermissions
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse                    JSON con información de los roles y permisos
     */
    public function getRolesAndPermissions()
    {
        /** @var Role Objeto con información de roles registrados */
        $roles = Role::with('permissions')->where('slug', '<>', 'user')->get();
        /** @var Permission Objeto con información de los permisos registrados */
        $permissions = Permission::with('roles')->orderBy('model_prefix')->get();
        return response()->json(['result' => true, 'roles' => $roles, 'permissions' => $permissions], 200);
    }

    /**
     * Configuración de permisos asociados a roles de usuarios
     *
     * @method  setRolesAndPermissions
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param Request  $request
     *
     * @return JsonResponse Retorna la vista que ejecuta la acción junto con el mensaje al usuario
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

        /** @var array Arreglo con listado de roles y permisos asociados */
        $rolesAndPerms = [];

        // Crea un arreglo de permisos asociados a los diferentes roles seleccionados
        foreach ($request->roles_attach_permissions as $role_perm) {
            list($role_id, $perm_id) = explode("_", $role_perm);
            if (!array_key_exists($role_id, $rolesAndPerms)) {
                $rolesAndPerms[$role_id] = [];
            }
            array_push($rolesAndPerms[$role_id], $perm_id);
        }

        // Asigna los distintos permisos a los roles
        foreach ($rolesAndPerms as $roleId => $roleValues) {
            $role = Role::find($roleId);
            if ($role) {
                $role->syncPermissions($roleValues);
            }
        }

        return response()->json(['result' => true], 200);
    }

    /**
     * Muestra el formulario para la asignación de roles y permisos a usuarios
     *
     * @method  assignAccess
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  User   $user Modelo de Usuario
     *
     * @return \Illuminate\View\View
     */
    public function assignAccess(User $user)
    {
        return view('admin.setting-user-access', compact('user'));
    }

    /**
     * Assigna permisos de acceso a los usuarios del sistema
     *
     * @method  setAccess
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param Request $request Objeto con los datos de la petición
     */
    public function setAccess(Request $request)
    {
        /** @var array Arreglo con reglas de validación */
        $rules = [
            'user' => ['required'],
            'role' => ['required_without:permission', 'array'],
            'permission' => ['required_without:role', 'array', 'min:1']
        ];
        /** @var array Arreglo con mensajes de validación */
        $messages = [
            'user.required' => __('Se requiere de un usuario para asignar roles y permisos'),
            'role.max' => __('Solo puede asignar un rol al usuario'),
            'permission.min' => __('Se requiere al menos un permiso asignado al usuario')
        ];

        /** @var User Objeto con información de un usuario */
        $user = User::find($request->user);

        if (isset($request->role)) {
            foreach ($request->role as $role) {
                if (Role::find($role)->permissions->isEmpty()) {
                    $rules['permission'] = str_replace('required_without:role', 'required', $rules['permission']);
                    if (count($request->role) > 1) {
                        /** @var string Mensaje a mostrar en la validación de roles */
                        $msg = __(
                            'Uno de los roles seleccionados no tiene permisos asignados, ' .
                            'debe indicar los permisos de acceso'
                        );
                    } else {
                        /** @var string Mensaje a mostrar en la validación de roles */
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
     * @method  info
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  User                              $user Objero que abstrae información del usuario
     *
     * @return JsonResponse     Devuelve los datos asociados al usuario
     */
    public function info(User $user)
    {
        /** @var array Arreglo con las relaciones a incorporar en la información del usuario */
        $with = [];
        if ($user->profile !== null) {
            $with[] = 'profile';
        }
        if ($user->roles !== null) {
            $with[] = 'roles';
        }
        if ($user->permissions !== null) {
            $with[] = 'permissions';
        }

        if (!empty($with)) {
            $user->with($with);
        }

        return response()->json([
            'result' => true, 'user' => $user, 'permissions' => $user->getPermissions()
        ], 200);
    }

    /**
     * Muestra un listado de roles y permisos de usuario
     *
     * @method     indexRolesPermissions()
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
     * @method     userSettings()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\View\View           Devuelve la vista para la configuración de la cuenta de usuario
     */
    public function userSettings()
    {
        /** @var User Objeto con información del usuario autenticado en la aplicación */
        $user = auth()->user();
        /** @var object Objeto con información de los permisos asociados a un usuario */
        $userPermissions = $user->getPermissions()->where('slug', '<>', '')->pluck('slug')->toArray();
        /** @var array Arreglo con información de los permisos asociados a notificaciones de usuarios */
        $arr = array_filter($userPermissions, function ($value, $index) {
            return strpos($value, 'notify') !== false;
        }, ARRAY_FILTER_USE_BOTH);
        /** @var array Arreglo de permisos para notificaciones */
        $userPermissions = $arr;

        /** @var NotificationSetting Objeto con información de la configuración de notificaciones */
        $notifySettings = NotificationSetting::whereIn(
            'perm_required',
            $userPermissions
        )->orWhereNull('perm_required')->get();

        /** @var array Arreglo con los atributos del formulario para el registro de configuraciones del usuario */
        $header_general_settings = [
            'route' => 'set.my.settings', 'method' => 'POST', 'role' => 'form', 'class' => 'form'
        ];
        /** @var array Arreglo con los atributos del formulario para la configuraciones de notificaciones del usuario */
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
     * @method     setUserSettings(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request            $request   Objeto con datos de la petición
     *
     * @return     RedirectResponse     redirecciona a la página de configuración del usuario
     */
    public function setUserSettings(Request $request)
    {
        /** @var User Objeto con información de un usuario */
        $user = User::find(auth()->user()->id);
        $user->lock_screen = (!is_null($request->lock_screen));
        $user->time_lock = $request->time_lock ?? 10;
        $user->save();

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->route('my.settings');
    }

    /**
     * Establece la configuración de un usuario desde el panel administrativo
     *
     * @method    setAdminUserSetting
     *
     * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request                $request    Datos de la petición
     */
    public function setAdminUserSetting(Request $request)
    {
        $user = User::find($request->user_id);
        $user->blocked_at = ($request->blocked_at === true) ? Carbon::now() : null;
        $user->active = ($request->active === true) ? true : false;
        $user->save();
        return response()->json(['result' => true], 200);
    }

    /**
     * Gestiona la configuración de notificaciones establecida por el usuario
     *
     * @method     setMyNotifications(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @license    [description]
     *
     * @param      Request               $request    [description]
     */
    public function setMyNotifications(Request $request)
    {
        /** @var object Objeto con informaciós de las configuraciones del usuario a establecer */
        $fields = $request->all();

        if (count($fields) > 1) {
            auth()->user()->notificationSettings()->detach();
            /** @var array Arreglo con los identificadores de las configuraciones de notificaciones */
            $notifications = [];
            foreach ($fields as $keyField => $valueField) {
                if ($keyField === '_token') {
                    continue;
                }
                /** @var NotificationSetting Objeto con información de la configuración de notificación */
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
     * @method     getLockScreenData()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     JsonResponse     Devuelve los datos correspondientes a la pantalla de bloqueo
     */
    public function getLockScreenData()
    {
        $user = auth()->user();
        return response()->json(['lock_screen' => $user->lock_screen, 'time_lock' => $user->time_lock], 200);
    }

    /**
     * Actualiza información de la pantalla de bloqueo del sistema
     *
     * @method     setLockScreenData(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    Datos de la petición
     *
     * @return      JsonResponse     Devuelve el resultado de la operación
     */
    public function setLockScreenData(Request $request)
    {
        /** @var User Objeto con información de un usuario */
        $user = User::find(auth()->user()->id);
        $user->lock_screen = $request->lock_screen;
        $user->save();
        return response()->json(['result' => true], 200);
    }

    /**
     * Realiza las gestiones necesarias para desbloquear la pantalla del sistema
     *
     * @method     unlockScreen(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    Datos de la petición
     *
     * @return     JsonResponse     Devuelve el resultado de la operación
     */
    public function unlockScreen(Request $request)
    {
        /** @var User Objeto con información de un usuario */
        $user = User::where('username', $request->username)->first();

        /** Verifica si la contraseña es correcta, de lo contrario retorna falso */
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['result' => false], 200);
        }

        // Agregar funcionalidad para determinar si el usuario esta autenticado (aplica para cuando expira la sesion)
        if (!auth()->check()) {
            /** @var object Objeto con información de las credenciales de acceso de un usuario */
            $userCredentials = $request->only('email', 'password');
            if (!Auth::attempt($userCredentials)) {
                return response()->json(['result' => false], 200);
            }
        }

        /** @var boolean actualiza el campo que determina si la pantalla de bloqueo esta o no activada */
        $user->lock_screen = false;
        $user->save();

        return response()->json(['result' => true, 'new_csrf' => csrf_token()], 200);
    }

    /**
     * Desbloquea un usuario
     *
     * @method    unlock
     *
     * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Datos de la petición
     * @param     User       $user       Usuario a desbloquear
     *
     * @return    ResponseJson
     */
    public function unlock(Request $request, User $user)
    {
        $user->blocked_at = null;
        $user->save();
        $request->session()->flash('message', ['type' => 'other', 'text' => 'Usuario desbloqueado']);
        return response()->json(['result' => true], 200);
    }

    /**
     * Obtiene información de todos los usuarios registrados en el sistema
     *
     * @method    getAll
     *
     * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse
     */
    public function getAll()
    {
        $users = User::select('id', 'name')->get();
        return response()->json(['result' => true, 'records' => $users]);
    }
}
