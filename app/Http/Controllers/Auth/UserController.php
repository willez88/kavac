<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

/**
 * @class UserController
 * @brief Gestiona información de usuarios
 * 
 * Controlador para gestionar usuarios
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class UserController extends Controller
{
    /**
     * Muesta todos los registros de los usuarios
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.settings-access');
    }

    /**
     * Muestra el formulario para crear un nuevo registro de usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra información acerca del usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Actualiza la información del usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if ($request->input('password')) {
            $this->validate($request, [
                'password' => 'min:6|confirmed',
                'password_confirmation' => 'min:6|required_with:password',
                'complexity-level' => 'numeric|min:43|max:100'
            ],[
                'confirmed' => 'La contraseña no coincide con la verificación',
                'required_with' => 'Debe confirmar la nueva contraseña',
                'complexity-level' => 'Contraseña muy débil. Intente incorporar símbolos, letras y números, ' . 
                                      'en cominación con mayúsculas y minúsculas.',
            ]);

            $user->password = bcrypt($request->input('password'));
            $user->save();

            $request->session()->flash('message', ['type' => 'update']);
        }
        else {
            $request->session()->flash('message', ['type' => 'other', 'text' => 'No se indicaron modificaciones']);
        }
        
        return redirect()->back();
    }

    /**
     * Elimina el usuario
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Configuración de permisos asociados a roles de usuarios
     * 
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Retorna la vista que ejecuta la acción junto con el mensaje al usuario
     */
    public function setRolesAndPermissions(Request $request)
    {
        $this->validate($request, [
            'perm' => 'required|array|min:1'
        ],[
            'perm.required' => 'Se requiere asignar al menos un permiso a un rol'
        ]);

        foreach (Role::all() as $r) {
            $r->detachAllPermissions();
        }

        $roleConsult = '';
        foreach ($request->input('perm') as $role_perm) {
            list($role_id, $perm_id) = explode(":", $role_perm);
            if ($roleConsult !== $role_id) {
                $role = Role::find($role_id);
                $roleConsult = $role_id;
            }
            $perm = Permission::find($perm_id);
            if (isset($role)) {
                $role->attachPermission($perm);
            }
        }

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->back();
    }

    /**
     * Assigna roles y permisos de acceso a los usuarios del sistema
     * 
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param Request $request Objeto con los datos de la petición
     */
    public function setAccess(Request $request)
    {

    }
}
