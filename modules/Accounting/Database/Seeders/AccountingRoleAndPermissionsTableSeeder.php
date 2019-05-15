<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;

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

            /**
            * cuentas patrimoniales
            */
            [
                'name' => 'Ver cuentas patrimoniales', 'slug' => 'accounting.account.list',
                'description' => 'Acceso para ver cuentas patrimoniales', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.ver', 'short_description' => 'listar cuentas patrimoniales'
            ],
            [
                'name' => 'Crear cuenta patrimonial', 'slug' => 'accounting.account.create',
                'description' => 'Acceso para crear cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.crear', 'short_description' => 'agregar cuentas patrimoniales'
            ],
            [
                'name' => 'Editar cuenta patrimonial', 'slug' => 'accounting.account.edit',
                'description' => 'Acceso para editar cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.editar', 'short_description' => 'editar cuentas patrimoniales'
            ],
            [
                'name' => 'Eliminar cuenta patrimonial', 'slug' => 'accounting.account.delete',
                'description' => 'Acceso para eliminar cuenta patrimonial', 
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.eliminar', 'short_description' => 'eliminar cuentas patrimoniales'
            ],

            /**
            * Convertidor de cuentas
            */
			[
                'name' => 'vista principal de consulta del convertidor de cuentas', 'slug' => 'accounting.converter.index',
                'description' => 'Acceso para listar conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.ver', 'short_description' => 'listar conversion'
            ],
            [
                'name' => 'Crear nueva conversión', 'slug' => 'accounting.converter.create',
                'description' => 'Acceso para crear nuevas conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.crear', 'short_description' => 'agregar conversion'
            ],
            [
                'name' => 'Editar conversiones', 'slug' => 'accounting.converter.edit',
                'description' => 'Acceso para editar registro conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.editar', 'short_description' => 'editar conversion'
            ],
            [
                'name' => 'Eliminar conversión', 'slug' => 'accounting.converter.delete',
                'description' => 'Acceso para eliminar registro de conversiones', 
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.eliminar', 'short_description' => 'eliminar conversion'
            ],

            /**
            * Asientos Contables
            */
            [
                'name' => 'listar asientos contables aprobados y no aprobados', 'slug' => 'accounting.seating.list',
                'description' => 'Acceso para listar asientos contable', 
                'model' => 'Modules\Accounting\Models\AccountingSeatController', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.ver', 'short_description' => 'listar asientos contables'
            ],
            [
                'name' => 'Crear asiento contable', 'slug' => 'accounting.seating.create',
                'description' => 'Acceso para crear asiento contable', 
                'model' => 'Modules\Accounting\Models\AccountingSeatController', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.crear', 'short_description' => 'crear asientos contables'
            ],
            [
                'name' => 'Editar asientos contables', 'slug' => 'accounting.seating.edit',
                'description' => 'Acceso para editar registro de asientos contables', 
                'model' => 'Modules\Accounting\Models\AccountingSeatController', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.editar', 'short_description' => 'editar asientos contables'
            ],
            [
                'name' => 'Eliminar asientos contables', 'slug' => 'accounting.seating.delete',
                'description' => 'Acceso para eliminar asiento contable', 
                'model' => 'Modules\Accounting\Models\AccountingSeatController', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.eliminar', 'short_description' => 'eliminar asiento contable'
            ],
            [
                'name' => 'Aprobar asientos contables', 'slug' => 'accounting.seating.approve',
                'description' => 'Acceso para aprobar asiento contable', 
                'model' => 'Modules\Accounting\Models\AccountingSeatController', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.approve', 'short_description' => 'aprobar asiento contable'
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
