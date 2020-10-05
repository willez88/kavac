<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\Profession;

/**
 * @class ProfessionsTableSeeder
 * @brief Información por defecto para Profesiones
 *
 * Gestiona la información por defecto a registrar inicialmente para las Profesiones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ProfessionsTableSeeder extends Seeder
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
         * Permisos disponibles para la gestión de profesiones
         */

        $permissions = [
            [
                'name' => 'Crear Profesiones', 'slug' => 'profession.create',
                'description' => 'Acceso al registro de profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.crear', 'short_description' => 'agregar profesión'
            ],
            [
                'name' => 'Editar Profesiones', 'slug' => 'profession.edit',
                'description' => 'Acceso para editar profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.editar', 'short_description' => 'editar profesión'
            ],
            [
                'name' => 'Eliminar Profesiones', 'slug' => 'profession.delete',
                'description' => 'Acceso para eliminar profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.eliminar', 'short_description' => 'eliminar profesión'
            ],
            [
                'name' => 'Ver Profesiones', 'slug' => 'profession.list',
                'description' => 'Acceso para ver profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.ver', 'short_description' => 'ver profesiones'
            ],
        ];

        $professions = [
            ['name' => 'Abogado(a)', 'acronym' => 'Abg'],
            ['name' => 'Arquitecto(a)', 'acronym' => 'Arq'],
            ['name' => 'Bachiller', 'acronym' => 'Bach'],
            ['name' => 'Criminólogo(a)', 'acronym' => ''],
            ['name' => 'Doctor(a)', 'acronym' => 'Dr'],
            ['name' => 'Doctor(a) en Ciencias Computacionales', 'acronym' => 'Dr'],
            ['name' => 'Economista', 'acronym' => 'Eco'],
            ['name' => 'Ingeniero(a) Civil', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) de Sistemas', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) Electricista', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) en Computación', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) en Electrónica', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) en Informática', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) Industrial', 'acronym' => 'Ing'],
            ['name' => 'Ingeniero(a) Mecánico', 'acronym' => 'Ing'],
            ['name' => 'Licenciado(a) en Administración', 'acronym' => 'Lic'],
            ['name' => 'Licenciado(a) en Ciencias Gerenciales', 'acronym' => 'Lic'],
            ['name' => 'Licenciado(a) en Comunicación Social', 'acronym' => 'Lic'],
            ['name' => 'Licenciado(a) en Contaduría Pública', 'acronym' => 'Lic'],
            ['name' => 'Licenciado(a) en Estadística', 'acronym' => 'Lic'],
            ['name' => 'Ninguna', 'acronym' => ''],
            ['name' => 'Politologo(a)', 'acronym' => 'Pol'],
            ['name' => 'T.S.U. en Administración', 'acronym' => 'T.S.U.'],
            ['name' => 'T.S.U. en Contaduría', 'acronym' => 'T.S.U.'],
            ['name' => 'T.S.U. en Informática', 'acronym' => 'T.S.U.'],
            ['name' => 'T.S.U. en Diseño', 'acronym' => 'T.S.U.'],
            ['name' => 'T.S.U. en Electrónica', 'acronym' => 'T.S.U.'],
        ];

        DB::transaction(function () use ($adminRole, $permissions, $professions) {
            foreach ($professions as $profession) {
                Profession::updateOrCreate(
                    ['name' => $profession['name']],
                    ['acronym' => ($profession['acronym'])?$profession['acronym']:null]
                );
            }

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
