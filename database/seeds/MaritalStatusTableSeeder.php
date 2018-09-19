<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;
use App\Models\MaritalStatus;

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

        MaritalStatus::updateOrCreate(['name' => 'Soltero(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Casado(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Divorciado(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Viudo(a)'],[]);

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de estados civiles
         */

        $permissions = [
            [
                'name' => 'Crear Estados Civiles', 'slug' => 'marital.status.create',
                'description' => 'Acceso al registro de estados civiles', 
                'model' => 'App\Models\MaritalStatus', 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.crear', 'short_description' => 'agregar estado civil'
            ],
            [
                'name' => 'Editar Estados Civiles', 'slug' => 'marital.status.edit',
                'description' => 'Acceso para editar estados civiles', 
                'model' => 'App\Models\MaritalStatus', 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.editar', 'short_description' => 'editar estado civil'
            ],
            [
                'name' => 'Eliminar Estados Civiles', 'slug' => 'marital.status.delete',
                'description' => 'Acceso para eliminar estados civiles', 
                'model' => 'App\Models\MaritalStatus', 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.eliminar', 'short_description' => 'eliminar estado civil'
            ],
            [
                'name' => 'Ver Estados Civiles', 'slug' => 'marital.status.list',
                'description' => 'Acceso para ver estados civiles', 
                'model' => 'App\Models\MaritalStatus', 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.ver', 'short_description' => 'ver estados civiles'
            ],
        ];

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
    }
}
