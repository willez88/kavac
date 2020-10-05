<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\Setting;
use App\Models\Institution;
use App\Models\Tax;
use App\Models\TaxUnit;
use App\Models\RequiredDocument;
use App\Models\ExchangeRate;
use App\Models\Currency;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Document;
use App\Models\Profession;
use OwenIt\Auditing\Models\Audit;

/**
 * @class PermissionsTableSeeder
 * @brief Información por defecto para Permisos de usuarios
 *
 * Gestiona la información por defecto a registrar inicialmente para los Permisos de usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PermissionsTableSeeder extends Seeder
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

        /** @var array Permisos disponibles para la gestión de registros comúnes */
        $permissions = [
            [
                'name' => 'Ver Logs del sistema', 'slug' => 'log.list',
                'description' => 'Acceso para ver bitácoras de registros del sistema',
                'model' => Audit::class, 'model_prefix' => '0general',
                'slug_alt' => 'log.list', 'short_description' => 'ver logs del sistema'
            ],
            [
                'name' => 'Restaurar registros del sistema', 'slug' => 'record.undelete',
                'description' => 'Acceso para restaurar registros del sistema',
                'model' => SoftDeletes::class, 'model_prefix' => '0general',
                'slug_alt' => 'registros.restaurar',
                'short_description' => 'restaurar registros del sistema'
            ],
            [
                'name' => 'Buscar registros en el sistema', 'slug' => 'record.search',
                'description' => 'Acceso para buscar registros en el sistema',
                'model' => null, 'model_prefix' => '0general', 'slug_alt' => 'registros.buscar',
                'short_description' => 'buscar registros en el sistema'
            ],
            [
                'name' => 'Enviar mensaje a usuario', 'slug' => 'user.message.send',
                'description' => 'Acceso para enviar mensajes a usuarios',
                'model' => null, 'model_prefix' => '0general', 'slug_alt' => 'usuario.mensaje.enviar',
                'short_description' => 'enviar mensajes a usuarios'
            ],
            [
                'name' => 'Configurar cuenta de usuario', 'slug' => 'user.setting',
                'description' => 'Acceso para configurar cuentas de usuarios',
                'model' => User::class, 'model_prefix' => '0general',
                'slug_alt' => 'usuario.configurar', 'short_description' => 'configurar usuarios'
            ],
            [
                'name' => 'Enviar Notificaciones a usuarios', 'slug' => 'user.notification.send',
                'description' => 'Acceso para enviar notificaciones a usuarios',
                'model' => User::class, 'model_prefix' => '0general',
                'slug_alt' => 'usuario.notificacion.enviar',
                'short_description' => 'enviar notificaciones a usuarios'
            ],
            [
                'name' => 'Ver información de usuarios', 'slug' => 'user.info',
                'description' => 'Acceso ver información de usuarios',
                'model' => User::class, 'model_prefix' => '0general',
                'slug_alt' => 'usuario.informacion',
                'short_description' => 'ver información de usuarios'
            ],
            [
                'name' => 'Asignar / Revocar permisos a usuarios', 'slug' => 'user.permissions',
                'description' => 'Acceso para asignar o revocar permisos a usuarios',
                'model' => User::class, 'model_prefix' => '0general',
                'slug_alt' => 'usuario.permiso',
                'short_description' => 'asignar / revocar permisos a usuarios'
            ],
            [
                'name' => 'Respaldar Base de Datos', 'slug' => 'database.backup',
                'description' => 'Acceso para respaldar base de datos',
                'model' => null, 'model_prefix' => '0general',
                'slug_alt' => 'basedatos.respaldar', 'short_description' => 'respaldar datos'
            ],
            [
                'name' => 'Restaurar Base de Datos', 'slug' => 'database.restore',
                'description' => 'Acceso para restaurar base de datos',
                'model' => null, 'model_prefix' => '0general',
                'slug_alt' => 'basedatos.restaurar', 'short_description' => 'restaurar datos'
            ],
            [
                'name' => 'Ver histórico de actividad personal', 'slug' => 'history.list',
                'description' => 'Acceso para ver histórico de acciones personales',
                'model' => Audit::class, 'model_prefix' => '0general',
                'slug_alt' => 'historico.ver', 'short_description' => 'ver historico personal'
            ],
            [
                'name' => 'Configurar parámetros generales', 'slug' => 'system.param.setting',
                'description' => 'Acceso para configurar parámetros generales del sistema',
                'model' => Setting::class, 'model_prefix' => '0general',
                'slug_alt' => 'sistema.parametro.configurar',
                'short_description' => 'configurar parámetros generales'
            ],
            [
                'name' => 'Configurar Instituciones', 'slug' => 'institution.setting',
                'description' => 'Acceso para configurar datos de Instituciones',
                'model' => Institution::class, 'model_prefix' => '0general',
                'slug_alt' => 'institucion.configurar',
                'short_description' => 'configurar instituciones'
            ],
            [
                'name' => 'Crear Impuestos', 'slug' => 'tax.create',
                'description' => 'Acceso al registro de impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'impuesto.crear', 'short_description' => 'agregar impuesto'
            ],
            [
                'name' => 'Editar Impuestos', 'slug' => 'tax.edit',
                'description' => 'Acceso para editar impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'impuesto.editar', 'short_description' => 'editar impuesto'
            ],
            [
                'name' => 'Eliminar Impuestos', 'slug' => 'tax.delete',
                'description' => 'Acceso para eliminar impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'impuesto.eliminar', 'short_description' => 'eliminar impuesto'
            ],
            [
                'name' => 'Ver Impuestos', 'slug' => 'tax.list',
                'description' => 'Acceso para ver impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'impuesto.ver', 'short_description' => 'ver impuestos'
            ],
            [
                'name' => 'Crear Unidades Tributarias', 'slug' => 'tax.unit.create',
                'description' => 'Acceso al registro de unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.tributaria.crear', 'short_description' => 'agregar unidad tributaria'
            ],
            [
                'name' => 'Editar Unidades Tributarias', 'slug' => 'tax.unit.edit',
                'description' => 'Acceso para editar unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.tributaria.editar', 'short_description' => 'editar unidad tributaria'
            ],
            [
                'name' => 'Eliminar Unidades Tributarias', 'slug' => 'tax.unit.delete',
                'description' => 'Acceso para eliminar unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.tributaria.eliminar', 'short_description' => 'eliminar unidad tributaria'
            ],
            [
                'name' => 'Ver Unidades Tributarias', 'slug' => 'tax.unit.list',
                'description' => 'Acceso para ver unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.tributaria.ver', 'short_description' => 'ver unidades tributarias'
            ],
            [
                'name' => 'Crear Documento Requerido', 'slug' => 'document.required.create',
                'description' => 'Acceso al registro de documentos requeridos',
                'model' => RequiredDocument::class, 'model_prefix' => '0general',
                'slug_alt' => 'solicitud.documentos.crear', 'short_description' => 'agregar documentos requeridos'
            ],
            [
                'name' => 'Editar Documento Requerido', 'slug' => 'document.required.edit',
                'description' => 'Acceso para editar documentos requeridos',
                'model' => RequiredDocument::class, 'model_prefix' => '0general',
                'slug_alt' => 'solicitud.documentos.editar', 'short_description' => 'editar documentos requeridos'
            ],
            [
                'name' => 'Eliminar Documento Requerido', 'slug' => 'document.required.delete',
                'description' => 'Acceso para eliminar documentos requeridos',
                'model' => RequiredDocument::class, 'model_prefix' => '0general',
                'slug_alt' => 'solicitud.documentos.eliminar', 'short_description' => 'eliminar documentos requeridos'
            ],
            [
                'name' => 'Ver Documento Requerido', 'slug' => 'document.required.list',
                'description' => 'Acceso para ver documentos requeridos',
                'model' => RequiredDocument::class, 'model_prefix' => '0general',
                'slug_alt' => 'solicitud.documentos.ver', 'short_description' => 'ver documentos requeridos'
            ],
            [
                'name' => 'Crear moneda', 'slug' => 'currency.create',
                'description' => 'Acceso al registro de monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'moneda.crear', 'short_description' => 'agregar monedas'
            ],
            [
                'name' => 'Editar moneda', 'slug' => 'currency.edit',
                'description' => 'Acceso para editar monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'moneda.editar', 'short_description' => 'editar monedas'
            ],
            [
                'name' => 'Eliminar moneda', 'slug' => 'currency.delete',
                'description' => 'Acceso para eliminar monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'moneda.eliminar', 'short_description' => 'eliminar monedas'
            ],
            [
                'name' => 'Ver moneda', 'slug' => 'currency.list',
                'description' => 'Acceso para ver monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'moneda.ver', 'short_description' => 'ver monedas'
            ],
            [
                'name' => 'Crear tipo de cambio', 'slug' => 'exchange.rate.create',
                'description' => 'Acceso al registro de tipos de cambios',
                'model' => ExchangeRate::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipos.cambio.crear', 'short_description' => 'agregar tipos de cambio'
            ],
            [
                'name' => 'Editar tipo de cambio', 'slug' => 'exchange.rate.edit',
                'description' => 'Acceso para editar tipos de cambio',
                'model' => ExchangeRate::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipos.cambio.editar', 'short_description' => 'editar tipos de cambio'
            ],
            [
                'name' => 'Eliminar tipo de cambio', 'slug' => 'exchange.rate.delete',
                'description' => 'Acceso para eliminar tipos de cambio',
                'model' => ExchangeRate::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipos.cambio.eliminar', 'short_description' => 'eliminar tipos de cambio'
            ],
            [
                'name' => 'Ver tipo de cambio', 'slug' => 'exchange.rate.list',
                'description' => 'Acceso para ver tipos de cambio',
                'model' => ExchangeRate::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipos.cambio.ver', 'short_description' => 'ver tipos de cambio'
            ],
            [
                'name' => 'Crear deducción / retención', 'slug' => 'deduction.create',
                'description' => 'Acceso al registro de deducciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'deduccion.crear', 'short_description' => 'agregar deducciones'
            ],
            [
                'name' => 'Editar deducción / retención', 'slug' => 'deduction.edit',
                'description' => 'Acceso para editar deducciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'deduccion.editar', 'short_description' => 'editar deducciones'
            ],
            [
                'name' => 'Eliminar deducción / retención', 'slug' => 'deduction.delete',
                'description' => 'Acceso para eliminar deducciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'deduccion.eliminar', 'short_description' => 'eliminar deducciones'
            ],
            [
                'name' => 'Ver deducción / retención', 'slug' => 'deduction.list',
                'description' => 'Acceso para ver deducciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'deduccion.ver', 'short_description' => 'ver deducciones'
            ],
            [
                'name' => 'Crear departamento', 'slug' => 'department.create',
                'description' => 'Acceso al registro de departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'departamento.crear', 'short_description' => 'agregar departamentos'
            ],
            [
                'name' => 'Editar departamento', 'slug' => 'department.edit',
                'description' => 'Acceso para editar departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'departamento.editar', 'short_description' => 'editar departamentos'
            ],
            [
                'name' => 'Eliminar departamento', 'slug' => 'department.delete',
                'description' => 'Acceso para eliminar departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'departamento.eliminar', 'short_description' => 'eliminar departamentos'
            ],
            [
                'name' => 'Ver departamento', 'slug' => 'department.list',
                'description' => 'Acceso para ver departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'departamento.ver', 'short_description' => 'ver departamentos'
            ],
            [
                'name' => 'Crear documento', 'slug' => 'document.create',
                'description' => 'Acceso al registro de documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'documento.crear', 'short_description' => 'agregar documentos'
            ],
            [
                'name' => 'Editar documento', 'slug' => 'document.edit',
                'description' => 'Acceso para editar documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'documento.editar', 'short_description' => 'editar documentos'
            ],
            [
                'name' => 'Eliminar documento', 'slug' => 'document.delete',
                'description' => 'Acceso para eliminar documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'documento.eliminar', 'short_description' => 'eliminar documentos'
            ],
            [
                'name' => 'Ver documento', 'slug' => 'document.list',
                'description' => 'Acceso para ver documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'documento.ver', 'short_description' => 'ver documentos'
            ],
            [
                'name' => 'Crear profesión', 'slug' => 'profession.create',
                'description' => 'Acceso al registro de profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.crear', 'short_description' => 'agregar profesiones'
            ],
            [
                'name' => 'Editar profesión', 'slug' => 'profession.edit',
                'description' => 'Acceso para editar profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.editar', 'short_description' => 'editar profesiones'
            ],
            [
                'name' => 'Eliminar profesión', 'slug' => 'profession.delete',
                'description' => 'Acceso para eliminar profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.eliminar', 'short_description' => 'eliminar profesiones'
            ],
            [
                'name' => 'Ver profesión', 'slug' => 'profession.list',
                'description' => 'Acceso para ver profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.ver', 'short_description' => 'ver profesiones'
            ],
        ];

        /** @var array combina el arreglo de permisos con el arreglo de permisos para notificaciones */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Notificar configuración de instituciones',
                'slug' => 'notify.institution',
                'description' => 'Notificar sobre configuración de datos de Instituciones',
                'model' => Institution::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.institucion.configurar',
                'short_description' => 'notificar la configuración de instituciones'
            ],
            [
                'name' => 'Notificar gestión de monedas',
                'slug' => 'notify.currency',
                'description' => 'Notificar sobre gestión de datos de monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.moneda',
                'short_description' => 'notificar la gestión de monedas'
            ],
            [
                'name' => 'Notificar gestión de deducciones / retenciones',
                'slug' => 'notify.deduction',
                'description' => 'Notificar sobre gestión de datos de deducciones / retenciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.deduccion',
                'short_description' => 'notificar la gestión de deducciones / retenciones'
            ],
            [
                'name' => 'Notificar gestión de impuestos',
                'slug' => 'notify.tax',
                'description' => 'Notificar sobre gestión de datos de impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.impuesto',
                'short_description' => 'notificar la gestión de impuestos'
            ],
            [
                'name' => 'Notificar gestión de unidades tributarias',
                'slug' => 'notify.taxunit',
                'description' => 'Notificar sobre gestión de datos de unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.unidad.tributaria',
                'short_description' => 'notificar la gestión de unidades tributarias'
            ],
            [
                'name' => 'Notificar gestión de departamentos',
                'slug' => 'notify.department',
                'description' => 'Notificar sobre gestión de datos de departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.departamento',
                'short_description' => 'notificar la gestión de departamentos'
            ],
            [
                'name' => 'Notificar gestión de documentos',
                'slug' => 'notify.document',
                'description' => 'Notificar sobre gestión de datos de documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.departamento',
                'short_description' => 'notificar la gestión de documentos'
            ],
            [
                'name' => 'Notificar gestión de profesiones',
                'slug' => 'notify.profession',
                'description' => 'Notificar sobre gestión de datos de profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'notificar.profesion',
                'short_description' => 'notificar la gestión de profesiones'
            ],
        ]);

        DB::transaction(function () use ($permissions, $adminRole) {
            foreach ($permissions as $permission) {
                $per = Permission::updateOrCreate(
                    ['slug' => $permission['slug']],
                    [
                        'name' => $permission['name'], 'description' => $permission['description'],
                        'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                        'slug_alt' => $permission['slug_alt'],
                        'short_description' => $permission['short_description']
                    ]
                );
                if ($adminRole) {
                    $adminRole->attachPermission($per);
                }
            }
        });
    }
}
