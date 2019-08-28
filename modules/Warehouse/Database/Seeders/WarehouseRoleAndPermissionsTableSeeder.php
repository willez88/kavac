<?php

namespace Modules\Warehouse\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Roles\Models\Role;
use App\Roles\Models\Permission;

/**
 * @class WarehouseRoleAndPermissionsTableSeeder
 * @brief Inicializa los roles y permisos del módulo de almacén
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseRoleAndPermissionsTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de los roles y permisos del módulo
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
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
             * Panel de Control
             */
            [
                'name' => 'Acceso al panel de control de almacén', 'slug' => 'warehouse.dashboard',
                'description' => 'Acceso al panel de control del módulo de almacén',
                'model' => '', 'model_prefix' => 'almacen',
                'slug_alt' => 'panel.control.ver', 'short_description' => 'panel de control de almacén'
            ],
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
                'slug_alt' => 'configuracion.almacen.producto',
                'short_description' => 'configuración de los productos almacenables'
            ],
            /**
             * Configuración de los atributos de los productos almacenables
            **/
            [
                'name' => 'Configuración de los atributos de los productos almacenables',
                'slug' => 'warehouse.setting.attribute',
                'description' => 'Acceso a la configuración de los atributos de los productos almacenables',
                'model' => 'Modules\Warehouse\Models\WarehouseProductAttribute', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.producto.atributo',
                'short_description' => 'configuración de los atributos de los productos almacenables'
            ],
            /**
             * Configuración de las unidades métricas de productos almacenables
            **/
            [
                'name' => 'Configuración de las unidades métricas de productos almacenables',
                'slug' => 'warehouse.setting.unit',
                'description' => 'Acceso a la configuración de las unidades métricas de productos almacenables',
                'model' => 'Modules\Warehouse\Models\WarehouseProductUnit', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.unidad',
                'short_description' => 'configuración de las unidades métricas de productos almacenables'
            ],
            /**
             * Configuración de las reglas de almacén
            **/
            [
                'name' => 'Configuración de las reglas de almacén', 'slug' => 'warehouse.setting.rule',
                'description' => 'Acceso a la configuración de las reglas de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseProductRule', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.regla',
                'short_description' => 'configuración de las reglas de almacén'
            ],
            /**
             * Cieres de Almacen
            **/
            [
                'name' => 'Configuración de los cierres de almacén', 'slug' => 'warehouse.setting.close',
                'description' => 'Acceso a la configuración de cierres de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseClose', 'model_prefix' => 'almacen',
                'slug_alt' => 'configuracion.almacen.cierre',
                'short_description' => 'configuración de los cierres de almacén'
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
            [
                'name' => 'Crear solicitud de almacén', 'slug' => 'warehouse.request.create',
                'description' => 'Acceso para crear solicitud de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseRequest', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.solicitud.crear', 'short_description' => 'agregar solicitud de almacén'
            ],
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
             * Movimientos de Almacén
            **/
            [
                'name' => 'Ver movimiento de artículos de almacén', 'slug' => 'warehouse.movement.list',
                'description' => 'Acceso para ver los movimientos de artículos de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseMovement', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.movimiento.ver', 'short_description' => 'ver movimiento de artículos de almacén'
            ],
            [
                'name' => 'Crear movimiento de artículos de almacén', 'slug' => 'warehouse.movement.create',
                'description' => 'Acceso para crear movimientos de artículos de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseMovement', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.movimiento.crear',
                'short_description' => 'agregar movimiento de artículos de almacén'
            ],
            [
                'name' => 'Editar movimiento de artículos de almacén', 'slug' => 'warehouse.movement.edit',
                'description' => 'Acceso para editar los movimientos de artículos de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseMovement', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.movimiento.editar',
                'short_description' => 'editar movimiento de artículos de almacén'
            ],
            [
                'name' => 'Eliminar movimiento de artículos de almacén', 'slug' => 'warehouse.movement.delete',
                'description' => 'Acceso para eliminar los movimientos de artículos de almacén',
                'model' => 'Modules\Warehouse\Models\WarehouseMovement', 'model_prefix' => 'almacen',
                'slug_alt' => 'almacen.movement.eliminar',
                'short_description' => 'eliminar movimiento de artículos de almacén'
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
