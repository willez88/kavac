<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\MaritalStatus;

/**
 * @class MaritalStatusTableSeeder
 * @brief Información por defecto para Estados Civiles
 * 
 * Gestiona la información por defecto a registrar inicialmente para los Estados Civiles
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de estados civiles
         */

        $permissions = [
            [
                'name' => 'Crear Estados Civiles', 'slug' => 'marital.status.create',
                'description' => 'Acceso al registro de estados civiles', 
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.crear', 'short_description' => 'agregar estado civil'
            ],
            [
                'name' => 'Editar Estados Civiles', 'slug' => 'marital.status.edit',
                'description' => 'Acceso para editar estados civiles', 
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.editar', 'short_description' => 'editar estado civil'
            ],
            [
                'name' => 'Eliminar Estados Civiles', 'slug' => 'marital.status.delete',
                'description' => 'Acceso para eliminar estados civiles', 
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.eliminar', 'short_description' => 'eliminar estado civil'
            ],
            [
                'name' => 'Ver Estados Civiles', 'slug' => 'marital.status.list',
                'description' => 'Acceso para ver estados civiles', 
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.ver', 'short_description' => 'ver estados civiles'
            ],
        ];

        DB::transaction(function() use ($adminRole, $permissions) {
            MaritalStatus::updateOrCreate(['name' => 'Soltero(a)'],[]);
            MaritalStatus::updateOrCreate(['name' => 'Casado(a)'],[]);
            MaritalStatus::updateOrCreate(['name' => 'Divorciado(a)'],[]);
            MaritalStatus::updateOrCreate(['name' => 'Viudo(a)'],[]);

            foreach ($permissions as $permission) {
                $per = Permission::updateOrCreate(
                    ['slug' => $permission['slug']],
                    [
                        'name' => $permission['name'], 'description' => $permission['description'],
                        'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                        'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                    ]
                );
                if ($adminRole) {
                    $adminRole->attachPermission($per);
                }
            }
        });
    }
}
