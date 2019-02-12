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
                'model' => '', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'configuración general de almacén'
            ],
            /**
             * Configuración de Alamcenes
            **/
            [
                'name' => 'Configuración de los Almacenes', 'slug' => 'warehouse.setting.warehouse',
                'description' => 'Acceso a la configuración de los almacenes', 
                'model' => 'Modules\Warehouse\Models\Warehouse', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen', 'short_description' => 'configuración de los almacenes'
            ],
            /**
             * Configuración de los productos almacenables
            **/
            [
                'name' => 'Configuración de los productos almacenables', 'slug' => 'warehouse.setting.product',
                'description' => 'Acceso a la configuración de los productos almacenables', 
                'model' => 'Modules\Warehouse\Models\WarehouseProduct', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.producto', 'short_description' => 'configuración de los productos almacenables'
            ],
            /**
             * Configuración de las unidades métricas de productos almacenables
            **/
            [
                'name' => 'Configuración de las unidades métricas de productos almacenables', 'slug' => 'warehouse.setting.unit',
                'description' => 'Acceso a la configuración de las unidades métricas de productos almacenables', 
                'model' => 'Modules\Warehouse\Models\WarehouseProductUnit', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.unidad', 'short_description' => 'configuración de las unidades métricas de productos almacenables'
            ],
            /**
             * Configuración de las reglas de almacén
            **/
            [
                'name' => 'Configuración de las reglas de almacén', 'slug' => 'warehouse.setting.rule',
                'description' => 'Acceso a la configuración de las reglas de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseProductRule', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.regla', 'short_description' => 'configuración de las reglas de almacén'
            ],
            /**
             * Cieres de Almacen
            **/
            [
                'name' => 'Configuración de los cierres de almacén', 'slug' => 'warehouse.setting.close',
                'description' => 'Acceso a la configuración de cierres de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.cierre', 'short_description' => 'configuración de los cierres de almacén'
            ],

            /**
             * Solicitudes de Almacén
            **/
            [
                'name' => 'Ver solicitud de almacén', 'slug' => 'warehouse.request.list',
                'description' => 'Acceso para ver las solicitudes de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseRequest', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.solicitud.ver', 'short_description' => 'ver solicitud de almacén'
            ],
            /*[
                'name' => 'Crear solicitud de almacén', 'slug' => 'warehouse.request.create',
                'description' => 'Acceso para crear solicitud de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseRequest', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.solicitud.crear', 'short_description' => 'agregar solicitud de almacén'
            ],*/
            [
                'name' => 'Editar solicitud de almacén', 'slug' => 'warehouse.request.edit',
                'description' => 'Acceso para editar solicitud de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseRequest', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.solicitud.editar', 'short_description' => 'editar solicitud de almacén'
            ],
            [
                'name' => 'Eliminar solicitud de almacén', 'slug' => 'warehouse.request.delete',
                'description' => 'Acceso para eliminar solicitud de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseRequest', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.solicitud.eliminar', 'short_description' => 'eliminar solicitud de bienes'
            ],
            /**
             * Recepciones de Almacén
            **/
            [
                'name' => 'Ver recepción de almacén', 'slug' => 'warehouse.reception.list',
                'description' => 'Acceso para ver las recepciones de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseReception', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.recepcion.ver', 'short_description' => 'ver recepción de almacén'
            ],
            /*[
                'name' => 'Crear recepción de almacén', 'slug' => 'warehouse.reception.create',
                'description' => 'Acceso para crear recepción de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseReception', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.recepcion.crear', 'short_description' => 'agregar recepción de almacén'
            ],*/
            [
                'name' => 'Editar recepción de almacén', 'slug' => 'warehouse.reception.edit',
                'description' => 'Acceso para editar las recepciones de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseReception', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.recepcion.editar', 'short_description' => 'editar recepción de almacén'
            ],
            [
                'name' => 'Eliminar recepción de almacén', 'slug' => 'warehouse.reception.delete',
                'description' => 'Acceso para eliminar recepción de almacén', 
                'model' => 'Modules\Warehouse\Models\WarehouseReception', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.reception.eliminar', 'short_description' => 'eliminar receción de bienes'
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
