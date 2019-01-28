<?php

namespace Modules\Warehouse\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

class WarehouseRoleAndPermissionsTableSeeder extends Seeder
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

        $warehouseRole = Role::updateOrCreate(
            ['slug' => 'warehouse'],
            ['name' => 'Almacén', 'description' => 'Coordinador de almacenes']
        );

        $permissions = [
            /**
             * Configuración General de Bienes
            **/
            [
                'name' => 'Configuración General del módulo de almacén', 'slug' => 'warehouse.setting',
                'description' => 'Acceso a la configuración general del módulo de almacén', 
                'model' => '', 'model_prefix' => 'warehouse',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'configuración general de almacén'
            ],
        ];
        
        $warehouseRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $warehouseRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }

    }
}
