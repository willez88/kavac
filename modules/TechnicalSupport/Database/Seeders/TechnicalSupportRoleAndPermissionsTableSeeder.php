<?php

namespace Modules\TechnicalSupport\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Roles\Models\Role;
use App\Roles\Models\Permission;

use Modules\TechnicalSupport\Models\TechnicalSupport;
use Modules\TechnicalSupport\Models\TechnicalSupportRepair;
use Modules\TechnicalSupport\Models\TechnicalSupportRequestRepair;

/**
 * @class TechnicalSupportRoleAndPermissionsTableSeeder
 * @brief Inicializa los roles y permisos del módulo de soporte técnico
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRoleAndPermissionsTableSeeder extends Seeder
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

        $technicalSupportRole = Role::updateOrCreate(
            ['slug' => 'technicalsupport'],
            ['name' => 'Soporte Técnico', 'description' => 'Coordinador de soporte técnico']
        );

        $permissions = [
            [
                'name'              => '',
                'slug'              => '',
                'description'       => '',
                'model'             => '',
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => '',
                'short_description' => ''
            ],
            /**
             * Configuración General del módulo de soporte técnico
             */
            [
                'name'              => 'Configuración general del módulo de soporte técnico',
                'slug'              => 'technicalsupport.setting',
                'description'       => 'Acceso a la configuración general del módulo de soporte técnico',
                'model'             => TechnicalSupport::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.configuracion.ver',
                'short_description' => 'Configuración general de soporte técnico'
            ],
            /**
             * Solicitudes de Reparación
             */
            [
                'name'              => 'Ver solicitudes de reparación',
                'slug'              => 'technicalsupport.requests.list',
                'description'       => 'Acceso para ver las solicitudes de reparación',
                'model'             => TechnicalSupportRequest::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.solicitud.ver',
                'short_description' => 'Ver solicitudes de reparación'
            ],
            [
                'name'              => 'Crear solicitud de reparación',
                'slug'              => 'technicalsupport.requests.create',
                'description'       => 'Acceso para crear solicitudes de reparación',
                'model'             => TechnicalSupportRequest::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.solicitud.crear',
                'short_description' => 'Crear solicitud de reparación'
            ],
            [
                'name'              => 'Editar solicitud de reparación',
                'slug'              => 'technicalsupport.requests.edit',
                'description'       => 'Acceso para editar las solicitudes de reparación',
                'model'             => TechnicalSupportRequest::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.solicitud.editar',
                'short_description' => 'Editar solicitud de reparación'
            ],
            [
                'name'              => 'Eliminar solicitud de reparación',
                'slug'              => 'technicalsupport.requests.delete',
                'description'       => 'Acceso para eliminar las solicitudes de reparación',
                'model'             => TechnicalSupportRequest::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.solicitud.eliminar',
                'short_description' => 'Eliminar solicitud de reparación'
            ],
            /**
             * Reparaciones
             */
            [
                'name'              => 'Ver reparaciones',
                'slug'              => 'technicalsupport.repairs.list',
                'description'       => 'Acceso para ver las reparaciones',
                'model'             => TechnicalSupportRepair::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.reparacion.ver',
                'short_description' => 'Ver reparaciones'
            ],
            [
                'name'              => 'Asignar responsable de reparación',
                'slug'              => 'technicalsupport.repairs.assign-responsible',
                'description'       => 'Acceso para asignar responsable de reparación',
                'model'             => TechnicalSupportRepair::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.reparacion.asignar-responsable',
                'short_description' => 'Asignar responsable de reparación'
            ],
            [
                'name'              => 'Cerrar reparación',
                'slug'              => 'technicalsupport.repairs.close',
                'description'       => 'Acceso para cerrar reparación y entregar equipos',
                'model'             => TechnicalSupportRepair::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.reparacion.cerrar',
                'short_description' => 'Cerrar reparación y entregar equipos'
            ],
            /**
             * Diagnósticos
             */
            [
                'name'              => 'Crear diagnóstico de reparación',
                'slug'              => 'technicalsupport.diagnostic.create',
                'description'       => 'Acceso para crear diagnóstico de reparación',
                'model'             => TechnicalSupportDiagnostic::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.diagnostico.crear',
                'short_description' => 'Crear diagnóstico de reparación'
            ],
            [
                'name'              => 'Editar diagnostico de reparación',
                'slug'              => 'technicalsupport.diagnostic.edit',
                'description'       => 'Acceso para editar los diagnósticos de las reparaciones',
                'model'             => TechnicalSupportDiagnostic::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.diagnostic.editar',
                'short_description' => 'Editar diagnóstico de reparación'
            ],
            [
                'name'              => 'Eliminar diagnóstico de reparación',
                'slug'              => 'technicalsupport.diagnostic.delete',
                'description'       => 'Acceso para eliminar los diagnósticos de las reparaciones',
                'model'             => TechnicalSupportDiagnostic::class,
                'model_prefix'      => 'soporte técnico',
                'slug_alt'          => 'soporte-tecnico.diagnostic.eliminar',
                'short_description' => 'Eliminar diagnóstico de reparación'
            ],
        ];

        $technicalSupportRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name'              => $permission['name'],
                    'description'       => $permission['description'],
                    'model'             => $permission['model'],
                    'model_prefix'      => $permission['model_prefix'],
                    'slug_alt'          => $permission['slug_alt'],
                    'short_description' => $permission['short_description']
                ]
            );

            $technicalSupportRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        };
    }
}
