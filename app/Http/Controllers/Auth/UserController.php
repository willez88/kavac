<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Muesta todos los registros de los usuarios
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings-access');
    }

    /**
     * Muestra el formulario para crear un nuevo registro de usuario
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo usuario
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
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
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
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
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
