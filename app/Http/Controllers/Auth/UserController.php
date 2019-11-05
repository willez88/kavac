<?php

/** Controladores para la gestión de autenticación de usuarios */
namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;

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
        return view('auth.register', compact('header'));
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

        /**
         * TODO:
         * - Extraer nombre de  la persona desde los datos personales mediante el campo staff
         * - Generar contraseña aleatoria
         * - Enviar datos de acceso por correo electrónico
         */

        return redirect()->route('index');
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
        if ($request->input('password')) {
            $this->validate($request, [
                'password' => ['min:6', 'confirmed'],
                'password_confirmation' => ['min:6', 'required_with:password'],
                'complexity-level' => ['numeric', 'min:43', 'max:100']
            ], [
                'confirmed' => 'La contraseña no coincide con la verificación',
                'required_with' => 'Debe confirmar la nueva contraseña',
                'complexity-level' => 'Contraseña muy débil. Intente incorporar símbolos, letras y números, ' .
                                      'en cominación con mayúsculas y minúsculas.',
            ]);

            $user->password = bcrypt($request->input('password'));
            $user->save();

            $request->session()->flash('message', ['type' => 'update']);
        } else {
            $request->session()->flash('message', ['type' => 'other', 'text' => 'No se indicaron modificaciones']);
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
            return response()->json(['result' => false, 'message' => 'Usted no puede eliminarse a si mismo'], 200);
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
            'roles_attach_permissions.required' => 'Se requiere asignar al menos un permiso a un rol'
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
            'user.required' => 'Se requiere de un usuario para asignar roles y permisos',
            'role.max' => 'Solo puede asignar un rol al usuario',
            'permission.min' => 'Se requiere al menos un permiso asignado al usuario'
        ];

        $user = User::find($request->user);

        if (isset($request->role)) {
            foreach ($request->role as $role) {
                if (Role::find($role)->permissions->isEmpty()) {
                    $rules['permission'] = str_replace('required_without:role', 'required', $rules['permission']);
                    if (count($request->role) > 1) {
                        $msg = 'Uno de los roles seleccionados no tiene permisos asignados, ' .
                               'debe indicar los permisos de acceso';
                    } else {
                        $msg = 'El rol seleccionado no tiene permisos asignados, debe indicar los permisos de acceso';
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

    public function indexRolesPermissions()
    {
        return view('admin.settings-access');
    }
}
