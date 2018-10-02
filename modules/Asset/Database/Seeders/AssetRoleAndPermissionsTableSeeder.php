<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;


class AssetRoleAndPermissionsTableSeeder extends Seeder
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

        $assetRole = Role::updateOrCreate(
            ['slug' => 'asset'],
            ['name' => 'Bienes', 'description' => 'Coordinador de bienes']
        );

        $permissions = [
            /**
             * Configuración General de Bienes
            **/
            [
                'name' => 'Configuración General del módulo de bienes', 'slug' => 'asset.setting',
                'description' => 'Acceso a la configuración general del módulo de bienes', 
                'model' => '', 'model_prefix' => 'bienes',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'configuración general de bienes'
            ],
            /**
             * Configuración de Tipos de Bienes
            **/
            [
                'name' => 'Configuración de los tipos de bienes', 'slug' => 'asset.setting.type',
                'description' => 'Acceso a la configuración de los tipos de bienes', 
                'model' => 'Modules\Asset\Models\AssetType', 'model_prefix' => 'bienes',
                'slug_alt' => 'configuracion.bienes.tipo', 'short_description' => 'configuración de los tipos de bienes'
            ],
            /**
             * Configuración de las Categorias Generales de Bienes
            **/
            [
                'name' => 'Configuración de las Categorias Generales de bienes', 'slug' => 'asset.setting.category',
                'description' => 'Acceso a la configuración de las categorias de bienes', 
                'model' => 'Modules\Asset\Models\AssetCategory', 'model_prefix' => 'bienes',
                'slug_alt' => 'configuracion.bienes.categoria', 'short_description' => 'configuración de las categorias de bienes'
            ],
            /**
             * Configuración de las Subcategorias de Bienes
            **/
            [
                'name' => 'Configuración de las Subcategorias de bienes', 'slug' => 'asset.setting.subcategory',
                'description' => 'Acceso a la configuración de las subcategorias de bienes', 
                'model' => 'Modules\Asset\Models\AssetSubcategory', 'model_prefix' => 'bienes',
                'slug_alt' => 'configuracion.bienes.subcategoria', 'short_description' => 'configuración de las subcategorias de bienes'
            ],
            /**
             * Configuración de las Categorias Específicas de Bienes
            **/
            [
                'name' => 'Configuración de las categorias específicas de bienes', 'slug' => 'asset.setting.specific',
                'description' => 'Acceso a la configuración de las categorias específicas de bienes', 
                'model' => 'Modules\Asset\Models\AssetSpecificCategory', 'model_prefix' => 'bienes',
                'slug_alt' => 'configuracion.bienes.categoria.especifica', 'short_description' => 'configuración de las categorias específicas de bienes'
            ],
            /**
             * Ingreso de Bienes
            **/
            [
                'name' => 'Ver bienes', 'slug' => 'asset.list',
                'description' => 'Acceso a descripción del módulo de bienes', 
                'model' => 'Modules\Asset\Models\Asset', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.ver', 'short_description' => 'ver bienes'
            ],
            [
                'name' => 'Crear bienes', 'slug' => 'asset.create',
                'description' => 'Acceso al registro de bienes', 
                'model' => 'Modules\Asset\Models\Asset', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.crear', 'short_description' => 'agregar bienes'
            ],
            [
                'name' => 'Editar bienes', 'slug' => 'asset.edit',
                'description' => 'Acceso para editar bienes', 
                'model' => 'Modules\Asset\Models\Asset', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.editar', 'short_description' => 'editar bienes'
            ],
            [
                'name' => 'Eliminar bienes', 'slug' => 'asset.delete',
                'description' => 'Acceso para eliminar bienes', 
                'model' => 'Modules\Asset\Models\Asset', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.eliminar', 'short_description' => 'eliminar bienes'
            ],
            /**
             * Asignación de Bienes
            **/
            [
                'name' => 'Ver asignación bienes', 'slug' => 'asset.asignation.list',
                'description' => 'Acceso para ver las asignaciones de bienes', 
                'model' => 'Modules\Asset\Models\AssetAsignation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.asignacion.ver', 'short_description' => 'ver asignación de bienes'
            ],
            [
                'name' => 'Crear asignación bienes', 'slug' => 'asset.asignation.create',
                'description' => 'Acceso para crear asignación de bienes', 
                'model' => 'Modules\Asset\Models\AssetAsignation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.asignacion.crear', 'short_description' => 'agregar asignacion de bienes'
            ],
            [
                'name' => 'Editar asignación de bienes', 'slug' => 'asset.asignation.edit',
                'description' => 'Acceso para editar asignación de bienes', 
                'model' => 'Modules\Asset\Models\AssetAsignation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.asignacion.editar', 'short_description' => 'editar asignación de bienes'
            ],
            [
                'name' => 'Eliminar asignación de bienes', 'slug' => 'asset.asignation.delete',
                'description' => 'Acceso para eliminar asignación de bienes', 
                'model' => 'Modules\Asset\Models\AssetAsignation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.asignacion.eliminar', 'short_description' => 'eliminar asignación de bienes'
            ],
            /**
             * Desincorporación de Bienes
            **/
            [
                'name' => 'Ver desincorporación de bienes', 'slug' => 'asset.disincorporation.list',
                'description' => 'Acceso para ver las desincorporaciones de bienes', 
                'model' => 'Modules\Asset\Models\AssetDisincorporation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.desincorporacion.ver', 'short_description' => 'ver desincorporación de bienes'
            ],
            [
                'name' => 'Crear desincorporación de bienes', 'slug' => 'asset.disincorporation.create',
                'description' => 'Acceso para crear desincorporación de bienes', 
                'model' => 'Modules\Asset\Models\AssetDisincorporation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.desincorporacion.crear', 'short_description' => 'agregar desincorporación de bienes'
            ],
            [
                'name' => 'Editar desincorporación de bienes', 'slug' => 'asset.disincorporation.edit',
                'description' => 'Acceso para editar desincorporación de bienes', 
                'model' => 'Modules\Asset\Models\AssetDisincorporation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.desincorporacion.editar', 'short_description' => 'editar desincorporación de bienes'
            ],
            [
                'name' => 'Eliminar desincorporación de bienes', 'slug' => 'asset.disincorporation.delete',
                'description' => 'Acceso para eliminar desincorporación de bienes', 
                'model' => 'Modules\Asset\Models\AssetDisincorporation', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.desincorporacion.eliminar', 'short_description' => 'eliminar desincorporación de bienes'
            ],
            /**
             * Solicitudes de Bienes
            **/
            [
                'name' => 'Ver solicitud de bienes', 'slug' => 'asset.request.list',
                'description' => 'Acceso para ver las solicitudes de bienes', 
                'model' => 'Modules\Asset\Models\AssetRequest', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.solicitud.ver', 'short_description' => 'ver solicitud de bienes'
            ],
            [
                'name' => 'Crear solicitud de bienes', 'slug' => 'asset.request.create',
                'description' => 'Acceso para crear solicitud de bienes', 
                'model' => 'Modules\Asset\Models\AssetRequest', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.solicitud.crear', 'short_description' => 'agregar solicitud de bienes'
            ],
            [
                'name' => 'Editar solicitud de bienes', 'slug' => 'asset.request.edit',
                'description' => 'Acceso para editar solicitud de bienes', 
                'model' => 'Modules\Asset\Models\AssetRequest', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.solicitud.editar', 'short_description' => 'editar solicitud de bienes'
            ],
            [
                'name' => 'Eliminar solicitud de bienes', 'slug' => 'asset.request.delete',
                'description' => 'Acceso para eliminar solicitud de bienes', 
                'model' => 'Modules\Asset\Models\AssetRequest', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.solicitud.eliminar', 'short_description' => 'eliminar solicitud de bienes'
            ],
            /**
             * Reportes de Bienes
            **/
            [
                'name' => 'Crear reporte de bienes', 'slug' => 'asset.report.create',
                'description' => 'Acceso para crear reportes de bienes', 
                'model' => '', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.reporte.crear', 'short_description' => 'generar reporte de bienes'
            ],
            [
                'name' => 'Imprimir reporte de bienes', 'slug' => 'asset.report.print',
                'description' => 'Acceso para imprimir reportes de bienes', 
                'model' => '', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.reporte.imprimir', 'short_description' => 'imprimir reporte de bienes'
            ],
            [
                'name' => 'Descargar reporte de bienes', 'slug' => 'asset.report.download',
                'description' => 'Acceso para descargar reportes de bienes', 
                'model' => '', 'model_prefix' => 'bienes',
                'slug_alt' => 'bienes.reporte.descargar', 'short_description' => 'descargar reporte de bienes'
            ],
            


        ];


        $assetRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $assetRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }

    }
}
