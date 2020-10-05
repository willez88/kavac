<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\Country;

/**
 * @class CountriesTableSeeder
 * @brief Información por defecto para Países
 *
 * Gestiona la información por defecto a registrar inicialmente para los Países
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CountriesTableSeeder extends Seeder
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
         * Permisos disponibles para la gestión de países
         */

        $permissions = [
            [
                'name' => 'Crear Países', 'slug' => 'country.create',
                'description' => 'Acceso al registro de países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.crear', 'short_description' => 'agregar pais'
            ],
            [
                'name' => 'Editar Países', 'slug' => 'country.edit',
                'description' => 'Acceso para editar países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.editar', 'short_description' => 'editar pais'
            ],
            [
                'name' => 'Eliminar Países', 'slug' => 'country.delete',
                'description' => 'Acceso para eliminar países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.eliminar', 'short_description' => 'eliminar pais'
            ],
            [
                'name' => 'Ver Países', 'slug' => 'country.list',
                'description' => 'Acceso para ver países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.ver', 'short_description' => 'ver países'
            ],
        ];

        DB::transaction(function () use ($adminRole, $permissions) {
            Country::updateOrCreate(
                ['name' => 'Venezuela'],
                ['prefix' => '58']
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
