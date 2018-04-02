<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {
        	/** @var [Object] Crea el usuario por defecto de la aplicación */
    		$user_admin = User::updateOrCreate(
                ['username' => 'admin'],
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('123456'),
                    'level' => 1,
                    'created_at' => Carbon::now()
                ]
            );
	        if (!$user_admin) {
                throw new Exception('Error creando el usuario administrador por defecto');
            }

            /** @var [Object] Crea el rol de administrador del sistema */
            $adminRole = Role::updateOrCreate(
                ['slug' => 'admin'],
                [
                    'name' => 'Administrador',
                    'description' => 'Administrador de la aplicación',
                    'level' => 1,
                ]
            );

            /** Asigna el rol de administrador */
            $user_admin->attachRole($adminRole);

            /** @var [Object] Crea el rol de usuario del sistema */
            $userRole = Role::updateOrCreate(
                ['slug' => 'user'],
                [
                    'name' => 'Usuario',
                    'description' => 'Usuario de la aplicación',
                    'level' => 2,
                ]
            );
    	});
    }
}
