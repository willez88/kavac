<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

/**
 * @class AccountingRoleAndPermissionsTableSeeder
 * @brief Información por defecto para Roles y Permisos del módulo de contabilidad
 * 
 * Gestiona la información por defecto a registrar inicialmente para los Roles y Permisos del módulo de contabilidad
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingRoleAndPermissionsTableSeeder extends Seeder
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

        $budgetRole = Role::updateOrCreate(
            ['slug' => 'account'],
            ['name' => 'Contabilidad', 'description' => 'Coordinador de cuentas Contables']
        );

        $permissions = [
            [
                'name' => 'Ver cuentas patrimoniales', 'slug' => 'accounting.account.list',
                'description' => 'Acceso para ver cuentas patrimoniales', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.ver', 'short_description' => 'ver clasificador'
            ],
            [
                'name' => 'Crear cuenta patrimonial', 'slug' => 'accounting.account.create',
                'description' => 'Acceso para crear cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.crear', 'short_description' => 'agregar clasificador'
            ],
            [
                'name' => 'Editar cuenta patrimonial', 'slug' => 'accounting.account.edit',
                'description' => 'Acceso para editar cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.editar', 'short_description' => 'editar clasificador'
            ],
            [
                'name' => 'Eliminar cuenta patrimonial', 'slug' => 'accounting.account.delete',
                'description' => 'Acceso para eliminar cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.eliminar', 'short_description' => 'eliminar clasificador'
            ],
			[
                'name' => 'vista principal de consulta del convertidor de cuentas', 'slug' => 'accounting.converter.index',
                'description' => 'Acceso para listar conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.ver', 'short_description' => 'listar clasificador'
            ],
            [
                'name' => 'Crear nueva conversión', 'slug' => 'accounting.converter.create',
                'description' => 'Acceso para crear nuevas conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.crear', 'short_description' => 'agregar clasificador'
            ],
            [
                'name' => 'Editar conversiones', 'slug' => 'accounting.converter.edit',
                'description' => 'Acceso para editar registro conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.editar', 'short_description' => 'editar clasificador'
            ],
            [
                'name' => 'Eliminar conversión', 'slug' => 'accounting.converter.delete',
                'description' => 'Acceso para eliminar registro de conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'clasificador.eliminar', 'short_description' => 'eliminar clasificador'
            ],
        ];



        $budgetRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $budgetRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
