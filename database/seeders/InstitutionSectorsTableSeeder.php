<?php
namespace Database\Seeders;

use App\Roles\Models\Role;

use Illuminate\Database\Seeder;
use App\Roles\Models\Permission;
use App\Models\InstitutionSector;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * @class InstitutionSectorsTableSeeder
 * @brief Información por defecto para sectores de las Organizaciones
 *
 * Gestiona la información por defecto a registrar inicialmente para los sectores de las Organizaciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
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

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de sectores de organizaciones
         */

        $permissions = [
            [
                'name' => 'Crear Sector de Organización', 'slug' => 'institution.sector.create',
                'description' => 'Acceso al registro de sectores de organizaciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.crear', 'short_description' => 'agregar sector de Organización'
            ],
            [
                'name' => 'Editar Sector de Organización', 'slug' => 'institution.sector.edit',
                'description' => 'Acceso para editar sectores de organizaciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.editar', 'short_description' => 'editar sector de Organización'
            ],
            [
                'name' => 'Eliminar Sector de Organización', 'slug' => 'institution.sector.delete',
                'description' => 'Acceso para eliminar sectores de organizaciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.eliminar', 'short_description' => 'eliminar sector de Organización'
            ],
            [
                'name' => 'Ver Sector de Organización', 'slug' => 'institution.sector.list',
                'description' => 'Acceso para ver sectores de organizaciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'sector.institucion.ver', 'short_description' => 'ver sectores de organizaciones'
            ],
        ];

        DB::transaction(function () use ($adminRole, $permissions) {
            InstitutionSector::withTrashed()->updateOrCreate(
                ['name' => 'Desarrollo'], ['deleted_at' => null]
            );
            InstitutionSector::withTrashed()->updateOrCreate(
                ['name' => 'Ciencia y Tecnología'], ['deleted_at' => null]
            );
            InstitutionSector::withTrashed()->updateOrCreate(
                ['name' => 'Gobierno'], ['deleted_at' => null]
            );

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
