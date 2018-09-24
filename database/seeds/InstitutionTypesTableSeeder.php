<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;
use App\Models\InstitutionType;

class InstitutionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        InstitutionType::updateOrCreate(
        	['acronym' => 'EDSF'],
        	['name' => 'Ente Desentralizado sin fines empresariales']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'ALCD'],
        	['name' => 'Alcaldía']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'MINS'],
        	['name' => 'Ministerio']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'GOBR'],
        	['name' => 'Gobernación']
        );

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de tipos de instituciones
         */

        $permissions = [
            [
                'name' => 'Crear Tipo de Institución', 'slug' => 'institution.type.create',
                'description' => 'Acceso al registro de tipos de instituciones', 
                'model' => 'App\Models\InstitutionType', 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.crear', 'short_description' => 'agregar tipo de institución'
            ],
            [
                'name' => 'Editar Tipo de Institución', 'slug' => 'institution.type.edit',
                'description' => 'Acceso para editar tipos de instituciones', 
                'model' => 'App\Models\InstitutionType', 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.editar', 'short_description' => 'editar tipo de institución'
            ],
            [
                'name' => 'Eliminar Tipo de Institución', 'slug' => 'institution.type.delete',
                'description' => 'Acceso para eliminar tipos de instituciones', 
                'model' => 'App\Models\InstitutionType', 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.eliminar', 'short_description' => 'eliminar tipo de institución'
            ],
            [
                'name' => 'Ver Tipo de Institución', 'slug' => 'institution.type.list',
                'description' => 'Acceso para ver tipos de instituciones', 
                'model' => 'App\Models\InstitutionType', 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.ver', 'short_description' => 'ver tipos de instituciones'
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
