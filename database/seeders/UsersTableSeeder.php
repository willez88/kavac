<?php
namespace Database\Seeders;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Roles\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @class UsersTableSeeder
 * @brief Información por defecto para Usuarios
 *
 * Gestiona la información por defecto a registrar inicialmente para los Usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = $this->command->ask('Indique el correo del usuario administrador: ', 'admin@mail.com');
        $adminUser = $this->command->ask('Indique el usuario administrador: ', 'admin');
        $adminName = $this->command->ask("Indique el nombre del usuario ${adminUser}: ");
        $adminPass = $this->command->secret("Indique la contraseña del usuario ${adminUser}: ");

        DB::transaction(function () use ($adminEmail, $adminUser, $adminName, $adminPass) {
            /** @var object Crea el usuario por defecto de la aplicación */
            $user_admin = User::updateOrCreate(
                ['username' => $adminUser, 'email' => $adminEmail],
                [
                    'name' => $adminName,
                    'password' => Hash::make($adminPass),
                    'level' => 1,
                    'created_at' => Carbon::now(),
                    'email_verified_at' => Carbon::now()
                ]
            );
            if (!$user_admin) {
                throw new Exception('Error creando el usuario administrador por defecto');
            }

            /** @var object Busca el rol de administrador del sistema */
            $adminRole = Role::where('slug', 'admin')->first();

            if ($adminRole) {
                /** Asigna el rol de administrador */
                $user_admin->attachRole($adminRole);
            }

            if (config('app.debug')) {
                /** @var object Busca el rol de desarrollador del sistema */
                $devRole = Role::where('slug', 'dev')->first();

                if ($devRole) {
                    /** Asigna el rol de administrador */
                    $user_admin->attachRole($devRole);
                }

                $usrTest = $this->command->askWithCompletion(
                    '¿Desea crear un usuario de prueba?: ', ['y', 'n'], 'n'
                );

                if ($usrTest==='y') {
                    /** Crea un usuario de prueba para entornos de desarrollo, sin roles ni permisos */
                    User::updateOrCreate(
                        ['username' => 'user', 'email' => 'user@kavac-testing.com'],
                        [
                            'name' => 'Usuario de prueba',
                            'password' => Hash::make('123456'),
                            'level' => 2,
                            'created_at' => Carbon::now(),
                            'email_verified_at' => Carbon::now()
                        ]
                    );

                    print("Se ha creado un usuario de prueba con el nombre 'user' y contraseña '123456'\n\n");
                }
            }
        });
    }
}
