<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\InstitutionType;
use DB;

/**
 * @class InstitutionTypesTableSeeder
 * @brief Información por defecto para tipos de Instituciones
 *
 * Gestiona la información por defecto a registrar inicialmente para los tipos de Instituciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
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

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de tipos de instituciones
         */

        $permissions = [
            [
                'name' => 'Crear Tipo de Institución', 'slug' => 'institution.type.create',
                'description' => 'Acceso al registro de tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.crear', 'short_description' => 'agregar tipo de institución'
            ],
            [
                'name' => 'Editar Tipo de Institución', 'slug' => 'institution.type.edit',
                'description' => 'Acceso para editar tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.editar', 'short_description' => 'editar tipo de institución'
            ],
            [
                'name' => 'Eliminar Tipo de Institución', 'slug' => 'institution.type.delete',
                'description' => 'Acceso para eliminar tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.eliminar', 'short_description' => 'eliminar tipo de institución'
            ],
            [
                'name' => 'Ver Tipo de Institución', 'slug' => 'institution.type.list',
                'description' => 'Acceso para ver tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipo.institucion.ver', 'short_description' => 'ver tipos de instituciones'
            ],
        ];

        DB::transaction(function () use ($adminRole, $permissions) {
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
