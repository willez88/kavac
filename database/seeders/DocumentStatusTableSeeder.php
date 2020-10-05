<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\DocumentStatus;

/**
 * @class DocumentStatusTableSeeder
 * @brief Información por defecto para estados de Documentos
 *
 * Gestiona la información por defecto a registrar inicialmente para las estados de Documentos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DocumentStatusTableSeeder extends Seeder
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
         * Permisos disponibles para la gestión de estatus de documentos
         */

        $permissions = [
            [
                'name' => 'Crear Estatus de Documento', 'slug' => 'document.status.create',
                'description' => 'Acceso al registro de estatus de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estatus.documentos.crear', 'short_description' => 'agregar estatus de documentos'
            ],
            [
                'name' => 'Editar Estatus de Documento', 'slug' => 'document.status.edit',
                'description' => 'Acceso para editar estatus de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estatus.documentos.editar', 'short_description' => 'editar estatus de documentos'
            ],
            [
                'name' => 'Eliminar Estatus de Documento', 'slug' => 'document.status.delete',
                'description' => 'Acceso para eliminar estatus de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estatus.documentos.eliminar', 'short_description' => 'eliminar estatus de documentos'
            ],
            [
                'name' => 'Ver Estatus de Documento', 'slug' => 'document.status.list',
                'description' => 'Acceso para ver estatus de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estatus.documentos.ver', 'short_description' => 'ver estatus de documentos'
            ],
        ];

        $doc_status = [
            [
                'name' => 'Aprobado(a)',
                'description' => 'Aprobado(a) en todas las instancias',
                'color' => '#18CE0F',
                'action' => 'AP'
            ],
            [
                'name' => 'Rechazado(a)',
                'description' => 'Rechazado(a) en cualquiera de las instancias',
                'color' => '#FFB236',
                'action' => 'RE'
            ],
            [
                'name' => 'En Proceso',
                'description' => 'Contiene algunas firmas pero no todas las requeridas para su ' .
                                 'aprobación',
                'color' => '#2CA8FF',
                'action' => 'PR'
            ],
            [
                'name' => 'Elaborado(a)',
                'description' => 'Faltan todas las firmas',
                'color' => '#888',
                'action' => 'EL'
            ],
            [
                'name' => 'Anulado(a)',
                'description' => 'Anulado(a) antes de su aprobación',
                'color' => '#FF3636',
                'action' => 'AN'
            ],
            [
                'name' => 'Cerrado(a)',
                'description' => 'El documento o registro ha sido cerrado y no puede ser modificado',
                'color' => '#b4b0aa',
                'action' => 'CE'
            ],
        ];

        DB::transaction(function () use ($adminRole, $permissions, $doc_status) {
            foreach ($doc_status as $doc) {
                DocumentStatus::updateOrCreate(
                    ['name' => $doc['name']],
                    [
                        'description' => $doc['description'],
                        'color' => $doc['color'],
                        'action' => $doc['action']
                    ]
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
