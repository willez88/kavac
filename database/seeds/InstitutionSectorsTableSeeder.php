<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;
use App\Models\InstitutionSector;

/**
 * @class InstitutionSectorsTableSeeder
 * @brief Información por defecto para sectores de las Instituciones
 * 
 * Gestiona la información por defecto a registrar inicialmente para los sectores de las Instituciones
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class InstitutionSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        InstitutionSector::updateOrCreate(['name' => 'Desarrollo'],[]);
        InstitutionSector::updateOrCreate(['name' => 'Ciencia y Tecnología'],[]);
        InstitutionSector::updateOrCreate(['name' => 'Gobierno'],[]);

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de sectores de instituciones
         */

        $permissions = [
            [
                'name' => 'Crear Sector de Institución', 'slug' => 'institution.sector.create',
                'description' => 'Acceso al registro de sectores de instituciones', 
                'model' => 'App\Models\InstitutionSector', 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.crear', 'short_description' => 'agregar sector de institución'
            ],
            [
                'name' => 'Editar Sector de Institución', 'slug' => 'institution.sector.edit',
                'description' => 'Acceso para editar sectores de instituciones', 
                'model' => 'App\Models\InstitutionSector', 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.editar', 'short_description' => 'editar sector de institución'
            ],
            [
                'name' => 'Eliminar Sector de Institución', 'slug' => 'institution.sector.delete',
                'description' => 'Acceso para eliminar sectores de instituciones', 
                'model' => 'App\Models\InstitutionSector', 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.eliminar', 'short_description' => 'eliminar sector de institución'
            ],
            [
                'name' => 'Ver Sector de Institución', 'slug' => 'institution.sector.list',
                'description' => 'Acceso para ver sectores de instituciones', 
                'model' => 'App\Models\InstitutionSector', 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.ver', 'short_description' => 'ver sectores de instituciones'
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
