<?php
namespace Database\Seeders;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Roles\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistered;

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
        DB::transaction(function () {
            $usrAdmin = $this->command->askWithCompletion(
                '¿Desea crear un usuario administrador? (s)i/(n)o', ['s', 'n'], 'n'
            );

            if ($usrAdmin==='s') {
                $adminEmail = $this->command->ask('Indique el correo del usuario administrador', 'admin@mail.com');
                $adminUser = $this->command->ask('Indique el usuario administrador', 'admin');
                $adminName = $this->command->ask("Indique el nombre del usuario ${adminUser}");
                $adminPass = $this->command->secret("Indique la contraseña del usuario ${adminUser}");
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
            }

            if (config('app.debug')) {
                /** @var object Busca el rol de desarrollador del sistema */
                $devRole = Role::where('slug', 'dev')->first();

                if (isset($user_admin) && $devRole) {
                    /** Asigna el rol de administrador */
                    $user_admin->attachRole($devRole);
                }

                $usrTest = $this->command->askWithCompletion(
                    '¿Desea crear un usuario de prueba? (s)i/(n)o', ['s', 'n'], 'n'
                );

                if ($usrTest==='s') {
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

            $usrAsk = $this->command->askWithCompletion(
                '¿Desea crear otros usuarios? (s)i/(n)o', ['s', 'n'], 'n'
            );

            if ($usrAsk==='s') {
                $list = range(1, 12);
                $roles = Role::select('slug')->get()->map(function ($role) {
                    return $role->slug;
                })->toArray();
                $count = $this->command->askWithCompletion(
                    '¿Cuantos usuarios desea crear?', $list, str_replace(['[', ']'], ['', ''], json_encode($list))
                );
                
                foreach ($list as $number) {
                    if ((int)$number > (int)$count) {
                        break;
                    }
                    
                    $usrEmail = $this->command->ask('Indique el correo del usuario', null);
                    $usrUser = $this->command->ask('Indique el usuario', null);
                    $usrName = $this->command->ask("Indique el nombre del usuario ${usrUser}");
                    $password = generate_hash();
                    /** @var object Crea el usuario por defecto de la aplicación */
                    $user = User::updateOrCreate(
                        ['username' => $usrUser, 'email' => $usrEmail],
                        [
                            'name' => $usrName,
                            'password' => Hash::make($password),
                            'level' => 2,
                            'created_at' => Carbon::now(),
                            'email_verified_at' => Carbon::now()
                        ]
                    );
                    if (!$user) {
                        throw new Exception("Error creando el usuario ${usrUser}");
                    }

                    $roleAsk = $this->command->askWithCompletion(
                        "Indique el rol del usuario ${usrUser}", $roles, str_replace(['[', ']'], ['', ''], json_encode($roles))
                    );
        
                    if ($roleAsk) {
                        $rol = Role::where('slug', $roleAsk)->first();
                        /** Asigna el rol de administrador */
                        $user->attachRole($rol);
                    }

                    $user->notify(new UserRegistered($user, $password));
                    $user->sendEmailVerificationNotification();
                }
            }
        });
    }
}
