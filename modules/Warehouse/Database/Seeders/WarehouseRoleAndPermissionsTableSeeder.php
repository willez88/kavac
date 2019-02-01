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
                'model' => '', 'model_prefix' => '',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'configuración general de almacén'
            ],
            /**
             * Configuración de Alamcenes
            **/
            [
                'name' => 'Configuración de los Almacenes', 'slug' => 'warehouse.setting.warehouse',
                'description' => 'Acceso a la configuración de los almacenes', 
                'model' => 'Modules\Warehouse\Models\Warehouse', 'model_prefix' => 'warehouse',
                'slug_alt' => 'configuracion.almacen', 'short_description' => 'configuración de los almacenes'
            ],
            /**
             * Configuración de los productos almacenables
            **/
            [
                'name' => 'Configuración de los productos almacenables', 'slug' => 'warehouse.setting.product',
                'description' => 'Acceso a la configuración de los productos almacenables', 
                'model' => 'Modules\Warehouse\Models\WarehouseProduct', 'model_prefix' => 'WarehouseProduct',
                'slug_alt' => 'configuracion.almacen.producto', 'short_description' => 'configuración de los productos almacenables'
            ],
            /**
             * Configuración de las unidades métricas de productos almacenables
            **/
            [
                'name' => 'Configuración de las unidades métricas de productos almacenables', 'slug' => 'warehouse.setting.unit',
                'description' => 'Acceso a la configuración de las unidades métricas de productos almacenables', 
                'model' => 'Modules\Warehouse\Models\WarehouseProductUnit', 'model_prefix' => 'WarehouseProductUnit',
                'slug_alt' => 'configuracion.almacen.unidad', 'short_description' => 'configuración de las unidades métricas de productos almacenables'
            ],
            /**
             * Cieres de Almacen
            **/
            [
                'name' => 'Ver cierre de almacén', 'slug' => 'warehouse.close.index',
                'description' => 'Acceso para ver cierre de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'WarehouseClose',
                'slug_alt' => 'almacen.cierre.ver', 'short_description' => 'ver cierre de almacén'
            ],
            [
                'name' => 'Crear cierre de almacén', 'slug' => 'warehouse.close.create',
                'description' => 'Acceso para agregar cierre de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'WarehouseClose',
                'slug_alt' => 'almacen.cierre.crear', 'short_description' => 'agregar cierre de almacén'
            ],
            [
                'name' => 'Editar cierre de almacén', 'slug' => 'warehouse.close.edit',
                'description' => 'Acceso para editar cierre de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'WarehouseClose',
                'slug_alt' => 'almacen.cierre.editar', 'short_description' => 'editar cierre de almacén'
            ],
            [
                'name' => 'Eliminar cierre de almacén', 'slug' => 'warehouse.close.delete',
                'description' => 'Acceso para eliminar cierre de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'WarehouseClose',
                'slug_alt' => 'almacen.cierre.eliminar', 'short_description' => 'eliminar cierre de almacén'
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
