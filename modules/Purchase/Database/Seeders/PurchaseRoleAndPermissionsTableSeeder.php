<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;

/**
 * @class PurchaseRoleAndPermissionsTableSeeder
 * @brief Información por defecto para Roles y Permisos del módulo de compra
 * 
 * Gestiona la información por defecto a registrar inicialmente para los Roles y Permisos del módulo de compra
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PurchaseRoleAndPermissionsTableSeeder extends Seeder
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

        $purchaseRole = Role::updateOrCreate(
            ['slug' => 'purchase'],
            ['name' => 'Compra', 'description' => 'Coordinador de compra']
        );

        $permissions = [
            [
                'name' => 'Inicio del módulo de compra', 'slug' => 'purchase.home',
                'description' => 'Acceso a descripción del módulo de compra', 
                'model' => '', 'model_prefix' => 'compra',
                'slug_alt' => 'compra.inicio', 'short_description' => 'página de inicio'
            ],
            [
                'name' => 'Configuración del módulo de compra', 'slug' => 'purchase.setting.create',
                'description' => 'Acceso a la configuración del módulo de compra', 
                'model' => '', 'model_prefix' => 'compra',
                'slug_alt' => 'configuracion.crear', 'short_description' => 'agregar configuración'
            ],
            [
                'name' => 'Editar configuración del módulo de compra', 
                'slug' => 'purchase.setting.edit',
                'description' => 'Acceso para editar la configuración del módulo de compra', 
                'model' => '', 'model_prefix' => 'compra',
                'slug_alt' => 'configuracion.editar', 'short_description' => 'editar configuración'
            ],
            [
                'name' => 'Ver configuración del módulo de compra', 
                'slug' => 'purchase.setting.list',
                'description' => 'Acceso para ver la configuración del módulo de compra', 
                'model' => '', 'model_prefix' => 'compra',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'ver configuración'
            ],
            [
                'name' => 'Eliminar configuración del módulo de compra', 
                'slug' => 'purchase.setting.delete',
                'description' => 'Acceso para eliminar la configuración del módulo de compra', 
                'model' => '', 'model_prefix' => 'compra',
                'slug_alt' => 'configuracion.eliminar', 'short_description' => 'eliminar configuración'
            ],
            [
                'name' => 'Crear especialidad de proveedor', 'slug' => 'purchase.supplier-specialty.create',
                'description' => 'Acceso para crear especialidad de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierSpecialty', 'model_prefix' => 'compra',
                'slug_alt' => 'especialidad.proveedor.crear', 
                'short_description' => 'agregar especialidad de proveedor'
            ],
            [
                'name' => 'Editar especialidad de proveedor', 'slug' => 'purchase.supplier-specialty.edit',
                'description' => 'Acceso para editar especialidad de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierSpecialty', 'model_prefix' => 'compra',
                'slug_alt' => 'especialidad.proveedor.editar', 
                'short_description' => 'editar especialidad de proveedor'
            ],
            [
                'name' => 'Eliminar especialidad de proveedor', 
                'slug' => 'purchase.supplier-specialty.delete',
                'description' => 'Acceso para eliminar especialidad de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierSpecialty', 'model_prefix' => 'compra',
                'slug_alt' => 'especialidad.proveedor.eliminar', 
                'short_description' => 'eliminar especialidad de proveedor'
            ],
            [
                'name' => 'Ver especialidades de proveedores', 'slug' => 'purchase.supplier-specialty.list',
                'description' => 'Acceso para ver especialidades de proveedores', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierSpecialty', 'model_prefix' => 'compra',
                'slug_alt' => 'especialidad.proveedor.ver', 
                'short_description' => 'ver especialidad de proveedor'
            ],
            [
                'name' => 'Crear tipo de proveedor', 'slug' => 'purchase.supplier-type.create',
                'description' => 'Acceso para crear tipo de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierType', 'model_prefix' => 'compra',
                'slug_alt' => 'tipo.proveedor.crear', 
                'short_description' => 'agregar tipo de proveedor'
            ],
            [
                'name' => 'Editar tipo de proveedor', 'slug' => 'purchase.supplier-type.edit',
                'description' => 'Acceso para editar tipo de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierType', 'model_prefix' => 'compra',
                'slug_alt' => 'tipo.proveedor.editar', 
                'short_description' => 'editar tipo de proveedor'
            ],
            [
                'name' => 'Eliminar tipo de proveedor', 
                'slug' => 'purchase.supplier-type.delete',
                'description' => 'Acceso para eliminar tipo de proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierType', 'model_prefix' => 'compra',
                'slug_alt' => 'tipo.proveedor.eliminar', 
                'short_description' => 'eliminar tipo de proveedor'
            ],
            [
                'name' => 'Ver tipos de proveedores', 'slug' => 'purchase.supplier-type.list',
                'description' => 'Acceso para ver tipos de proveedores', 
                'model' => 'Modules\Budget\Models\PurchaseSupplierType', 'model_prefix' => 'compra',
                'slug_alt' => 'tipo.proveedor.ver', 
                'short_description' => 'ver tipo de proveedor'
            ],
            [
                'name' => 'Crear proveedor', 'slug' => 'purchase.supplier.create',
                'description' => 'Acceso para crear proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplier', 'model_prefix' => 'compra',
                'slug_alt' => 'proveedor.crear', 
                'short_description' => 'agregar proveedor'
            ],
            [
                'name' => 'Editar proveedor', 'slug' => 'purchase.supplier.edit',
                'description' => 'Acceso para editar proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplier', 'model_prefix' => 'compra',
                'slug_alt' => 'proveedor.editar', 
                'short_description' => 'editar proveedor'
            ],
            [
                'name' => 'Eliminar proveedor', 
                'slug' => 'purchase.supplier.delete',
                'description' => 'Acceso para eliminar proveedor', 
                'model' => 'Modules\Budget\Models\PurchaseSupplier', 'model_prefix' => 'compra',
                'slug_alt' => 'proveedor.eliminar', 
                'short_description' => 'eliminar proveedor'
            ],
            [
                'name' => 'Ver tipos de proveedores', 'slug' => 'purchase.supplier.list',
                'description' => 'Acceso para ver tipos de proveedores', 
                'model' => 'Modules\Budget\Models\PurchaseSupplier', 'model_prefix' => 'compra',
                'slug_alt' => 'proveedor.ver', 
                'short_description' => 'ver proveedor'
            ]
        ];

        $purchaseRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $purchaseRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
