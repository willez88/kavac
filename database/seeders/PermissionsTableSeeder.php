<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\City;
use App\Models\CodeSetting;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Estate;
use App\Models\ExchangeRate;
use App\Models\HistoryTax;
use App\Models\Institution;
use App\Models\InstitutionSector;
use App\Models\InstitutionType;
use App\Models\MaritalStatus;
use App\Models\MeasurementUnit;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\Profession;
use App\Models\RequiredDocument;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\TaxUnit;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;
use DB;

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

        /** @var array Permisos generales de la aplicación */
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
            ]
        ];

        /** @var array Permisos para la gestión de códigos de registro */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Código de Registro', 'slug' => 'code.settings.create',
                'description' => 'Acceso a la gestión de códigos de registro',
                'model' => CodeSetting::class, 'model_prefix' => '0general',
                'slug_alt' => 'codigo.registro.crear', 'short_description' => 'agregar código de registro'
            ],
            [
                'name' => 'Editar Código de Registro', 'slug' => 'code.settings.edit',
                'description' => 'Acceso para editar códigos de registro',
                'model' => CodeSetting::class, 'model_prefix' => '0general',
                'slug_alt' => 'codigo.registro.editar', 'short_description' => 'editar código de registro'
            ],
            [
                'name' => 'Eliminar Código de Registro', 'slug' => 'code.settings.delete',
                'description' => 'Acceso para eliminar códigos de registro',
                'model' => CodeSetting::class, 'model_prefix' => '0general',
                'slug_alt' => 'codigo.registro.eliminar', 'short_description' => 'eliminar código de registro'
            ],
            [
                'name' => 'Ver Código de Registro', 'slug' => 'code.settings.list',
                'description' => 'Acceso para ver códigos de registro',
                'model' => CodeSetting::class, 'model_prefix' => '0general',
                'slug_alt' => 'codigo.registro.ver', 'short_description' => 'ver códigos de registro'
            ],
            [
                'name' => 'Notificar gestión de códigos de registro',
                'slug' => 'code.settings.notify',
                'description' => 'Notificar sobre gestión de datos de códigos de registro',
                'model' => CodeSetting::class, 'model_prefix' => '0general',
                'slug_alt' => 'codigo.registro.notificar',
                'short_description' => 'notificar la gestión de códigos de registro'
            ],
        ]);

        /** @var array Permisos para la configuración de parámetros generales */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Configurar parámetros generales', 'slug' => 'system.param.setting',
                'description' => 'Acceso para configurar parámetros generales del sistema',
                'model' => Setting::class, 'model_prefix' => '0general',
                'slug_alt' => 'sistema.parametro.configurar',
                'short_description' => 'configurar parámetros generales'
            ],
            [
                'name' => 'Notificar configuración de parámetros generales', 'slug' => 'system.param.setting.notify',
                'description' => 'Notificar sobre configuración parámetros generales del sistema',
                'model' => Setting::class, 'model_prefix' => '0general',
                'slug_alt' => 'sistema.parametro.configurar.notificar',
                'short_description' => 'notificar la configuración de parámetros generales'
            ],
        ]);

        /** @var array Permisos para la gestión de instituciones */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Configurar Instituciones', 'slug' => 'institution.setting',
                'description' => 'Acceso para configurar datos de Instituciones',
                'model' => Institution::class, 'model_prefix' => '0general',
                'slug_alt' => 'institucion.configurar',
                'short_description' => 'configurar instituciones'
            ],
            [
                'name' => 'Notificar configuración de instituciones',
                'slug' => 'institution.notify',
                'description' => 'Notificar sobre configuración de datos de Instituciones',
                'model' => Institution::class, 'model_prefix' => '0general',
                'slug_alt' => 'institucion.configurar.notificar',
                'short_description' => 'notificar la configuración de instituciones'
            ],
        ]);

        /** @var array Permisos para la gestión de usuarios */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de usuarios', 'slug' => 'user.manage.notify',
                'description' => 'Notificar sobre gestión de usuarios',
                'model' => User::class, 'model_prefix' => '0general',
                'slug_alt' => 'usuario.gestion.notificar',
                'short_description' => 'notificar gestión de usuarios'
            ],
        ]);

        /** @var array Permisos para la gestión de impuestos */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de impuestos',
                'slug' => 'tax.notify',
                'description' => 'Notificar sobre gestión de datos de impuestos',
                'model' => Tax::class, 'model_prefix' => '0general',
                'slug_alt' => 'impuesto.notificar',
                'short_description' => 'notificar la gestión de impuestos'
            ],
        ]);

        /** @var array Permisos para la gestión de Unidades Tributarias */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de unidades tributarias',
                'slug' => 'tax.unit.notify',
                'description' => 'Notificar sobre gestión de datos de unidades tributarias',
                'model' => TaxUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.tributaria.notificar',
                'short_description' => 'notificar la gestión de unidades tributarias'
            ],
        ]);

        /** @var array Permisos para la gestión de documentos requeridos */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de Documento Requerido', 'slug' => 'document.required.notify',
                'description' => 'Notificar gestión de documentos requeridos',
                'model' => RequiredDocument::class, 'model_prefix' => '0general',
                'slug_alt' => 'solicitud.documentos.notificar',
                'short_description' => 'notificar gestión de documentos requeridos'
            ],
        ]);

        /** @var array Permisos para la gestión de monedas */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de monedas',
                'slug' => 'currency.notify',
                'description' => 'Notificar sobre gestión de datos de monedas',
                'model' => Currency::class, 'model_prefix' => '0general',
                'slug_alt' => 'moneda.notificar',
                'short_description' => 'notificar la gestión de monedas'
            ],
        ]);

        /** @var array Permisos para la gestión de tipos de cambio de monedas */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar tipo de cambio', 'slug' => 'exchange.rate.notify',
                'description' => 'Notificar gestión de tipos de cambio',
                'model' => ExchangeRate::class, 'model_prefix' => '0general',
                'slug_alt' => 'tipos.cambio.notificar', 'short_description' => 'notificar gestión de tipos de cambio'
            ],
        ]);

        /** @var array Permisos para la gestión de deducciones / retenciones */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de deducciones / retenciones',
                'slug' => 'deduction.notify',
                'description' => 'Notificar sobre gestión de datos de deducciones / retenciones',
                'model' => Deduction::class, 'model_prefix' => '0general',
                'slug_alt' => 'deduccion.notificar',
                'short_description' => 'notificar la gestión de deducciones / retenciones'
            ],
        ]);

        /** @var array Permisos para la gestión de departamentos */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de departamentos',
                'slug' => 'department.notify',
                'description' => 'Notificar sobre gestión de datos de departamentos',
                'model' => Department::class, 'model_prefix' => '0general',
                'slug_alt' => 'departamento.notificar',
                'short_description' => 'notificar la gestión de departamentos'
            ],
        ]);

        /** @var array Permisos para la gestión de documentos */
        $permissions = array_merge($permissions, [
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
                'name' => 'Notificar gestión de documentos',
                'slug' => 'document.notify',
                'description' => 'Notificar sobre gestión de datos de documentos',
                'model' => Document::class, 'model_prefix' => '0general',
                'slug_alt' => 'document.notificar',
                'short_description' => 'notificar la gestión de documentos'
            ],
        ]);

        /** @var array Permisos para la gestión de estados de documentos */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear estado de documento', 'slug' => 'document.status.create',
                'description' => 'Acceso al registro de estado de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.documento.crear', 'short_description' => 'agregar estado de documentos'
            ],
            [
                'name' => 'Editar estado de documento', 'slug' => 'document.status.edit',
                'description' => 'Acceso para editar estado de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.documento.editar', 'short_description' => 'editar estado de documentos'
            ],
            [
                'name' => 'Eliminar estado de documento', 'slug' => 'document.status.delete',
                'description' => 'Acceso para eliminar estado de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.documento.eliminar', 'short_description' => 'eliminar estado de documentos'
            ],
            [
                'name' => 'Ver estado de documento', 'slug' => 'document.status.list',
                'description' => 'Acceso para ver estado de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.documento.ver', 'short_description' => 'ver estado de documentos'
            ],
            [
                'name' => 'Notificar gestión de estado de documentos',
                'slug' => 'document.status.notify',
                'description' => 'Notificar sobre gestión de datos de estado de documentos',
                'model' => DocumentStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.documento.notificar',
                'short_description' => 'notificar la gestión de estado de documentos'
            ],
        ]);

        /** @var array Permisos para la gestión de profesiones */
        $permissions = array_merge($permissions, [
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
            [
                'name' => 'Notificar gestión de profesiones',
                'slug' => 'profession.notify',
                'description' => 'Notificar sobre gestión de datos de profesiones',
                'model' => Profession::class, 'model_prefix' => '0general',
                'slug_alt' => 'profesion.notificar',
                'short_description' => 'notificar la gestión de profesiones'
            ],
        ]);

        /** @var array Permisos para la gestión de ciudades */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Ciudades', 'slug' => 'city.create',
                'description' => 'Acceso al registro de ciudades',
                'model' => City::class, 'model_prefix' => '0general',
                'slug_alt' => 'ciudad.crear', 'short_description' => 'agregar ciudad'
            ],
            [
                'name' => 'Editar Ciudades', 'slug' => 'city.edit',
                'description' => 'Acceso para editar ciudades',
                'model' => City::class, 'model_prefix' => '0general',
                'slug_alt' => 'ciudad.editar', 'short_description' => 'editar ciudad'
            ],
            [
                'name' => 'Eliminar Ciudades', 'slug' => 'city.delete',
                'description' => 'Acceso para eliminar ciudades',
                'model' => City::class, 'model_prefix' => '0general',
                'slug_alt' => 'ciudad.eliminar', 'short_description' => 'eliminar ciudad'
            ],
            [
                'name' => 'Ver Ciudades', 'slug' => 'city.list',
                'description' => 'Acceso para ver ciudades',
                'model' => City::class, 'model_prefix' => '0general',
                'slug_alt' => 'ciudad.ver', 'short_description' => 'ver ciudades'
            ],
            [
                'name' => 'Notificar gestión de ciudades',
                'slug' => 'city.notify',
                'description' => 'Notificar sobre gestión de datos de ciudades',
                'model' => City::class, 'model_prefix' => '0general',
                'slug_alt' => 'ciudad.notificar',
                'short_description' => 'notificar la gestión de ciudades'
            ],
        ]);

        /** @var array Permisos para la gestión de países */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Países', 'slug' => 'country.create',
                'description' => 'Acceso al registro de países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.crear', 'short_description' => 'agregar pais'
            ],
            [
                'name' => 'Editar Países', 'slug' => 'country.edit',
                'description' => 'Acceso para editar países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.editar', 'short_description' => 'editar pais'
            ],
            [
                'name' => 'Eliminar Países', 'slug' => 'country.delete',
                'description' => 'Acceso para eliminar países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.eliminar', 'short_description' => 'eliminar pais'
            ],
            [
                'name' => 'Ver Países', 'slug' => 'country.list',
                'description' => 'Acceso para ver países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.ver', 'short_description' => 'ver países'
            ],
            [
                'name' => 'Notificar gestión de países',
                'slug' => 'country.notify',
                'description' => 'Notificar sobre gestión de datos de países',
                'model' => Country::class, 'model_prefix' => '0general',
                'slug_alt' => 'pais.notificar',
                'short_description' => 'notificar la gestión de países'
            ],
        ]);

        /** @var array Permisos para la gestión de Estados */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Estados', 'slug' => 'estate.create',
                'description' => 'Acceso al registro de Estados',
                'model' => Estate::class, 'model_prefix' => '0general',
                'slug_alt' => 'estate.crear', 'short_description' => 'agregar estado'
            ],
            [
                'name' => 'Editar Estados', 'slug' => 'estate.edit',
                'description' => 'Acceso para editar Estados',
                'model' => Estate::class, 'model_prefix' => '0general',
                'slug_alt' => 'estate.editar', 'short_description' => 'editar estado'
            ],
            [
                'name' => 'Eliminar Estados', 'slug' => 'estate.delete',
                'description' => 'Acceso para eliminar Estados',
                'model' => Estate::class, 'model_prefix' => '0general',
                'slug_alt' => 'estate.eliminar', 'short_description' => 'eliminar estado'
            ],
            [
                'name' => 'Ver Estados', 'slug' => 'estate.list',
                'description' => 'Acceso para ver Estados',
                'model' => Estate::class, 'model_prefix' => '0general',
                'slug_alt' => 'estate.ver', 'short_description' => 'ver Estados'
            ],
            [
                'name' => 'Notificar gestión de Estados',
                'slug' => 'estate.notify',
                'description' => 'Notificar sobre gestión de datos de Estados',
                'model' => Estate::class, 'model_prefix' => '0general',
                'slug_alt' => 'estate.notificar',
                'short_description' => 'notificar la gestión de Estados'
            ],
        ]);

        /** @var array Permisos para la gestión de Municipios */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Municipios', 'slug' => 'municipality.create',
                'description' => 'Acceso al registro de Municipios',
                'model' => Municipality::class, 'model_prefix' => '0general',
                'slug_alt' => 'municipality.crear', 'short_description' => 'agregar municipio'
            ],
            [
                'name' => 'Editar Municipios', 'slug' => 'municipality.edit',
                'description' => 'Acceso para editar Municipios',
                'model' => Municipality::class, 'model_prefix' => '0general',
                'slug_alt' => 'municipality.editar', 'short_description' => 'editar municipio'
            ],
            [
                'name' => 'Eliminar Municipios', 'slug' => 'municipality.delete',
                'description' => 'Acceso para eliminar Municipios',
                'model' => Municipality::class, 'model_prefix' => '0general',
                'slug_alt' => 'municipality.eliminar', 'short_description' => 'eliminar municipio'
            ],
            [
                'name' => 'Ver Municipios', 'slug' => 'municipality.list',
                'description' => 'Acceso para ver Municipios',
                'model' => Municipality::class, 'model_prefix' => '0general',
                'slug_alt' => 'municipality.ver', 'short_description' => 'ver Municipios'
            ],
            [
                'name' => 'Notificar gestión de Municipios',
                'slug' => 'municipality.notify',
                'description' => 'Notificar sobre gestión de datos de Municipios',
                'model' => Municipality::class, 'model_prefix' => '0general',
                'slug_alt' => 'municipality.notificar',
                'short_description' => 'notificar la gestión de Municipios'
            ],
        ]);

        /** @var array Permisos para la gestión de Parroquias */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear Parroquias', 'slug' => 'parish.create',
                'description' => 'Acceso al registro de Parroquias',
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parish.crear', 'short_description' => 'agregar parroquia'
            ],
            [
                'name' => 'Editar Parroquias', 'slug' => 'parish.edit',
                'description' => 'Acceso para editar Parroquias',
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parish.editar', 'short_description' => 'editar parroquia'
            ],
            [
                'name' => 'Eliminar Parroquias', 'slug' => 'parish.delete',
                'description' => 'Acceso para eliminar Parroquias',
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parish.eliminar', 'short_description' => 'eliminar parroquia'
            ],
            [
                'name' => 'Ver Parroquias', 'slug' => 'parish.list',
                'description' => 'Acceso para ver Parroquias',
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parish.ver', 'short_description' => 'ver Parroquias'
            ],
            [
                'name' => 'Notificar gestión de Parroquias',
                'slug' => 'parish.notify',
                'description' => 'Notificar sobre gestión de datos de Parroquias',
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parish.notificar',
                'short_description' => 'notificar la gestión de Parroquias'
            ],
        ]);

        /** @var array Permisos para la gestión de histórico de impuestos */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear histórico de impuestos', 'slug' => 'history.tax.create',
                'description' => 'Acceso al registro de histórico de impuestos',
                'model' => HistoryTax::class, 'model_prefix' => '0general',
                'slug_alt' => 'history.tax.crear', 'short_description' => 'agregar histórico de impuesto'
            ],
            [
                'name' => 'Editar histórico de impuestos', 'slug' => 'history.tax.edit',
                'description' => 'Acceso para editar histórico de impuestos',
                'model' => HistoryTax::class, 'model_prefix' => '0general',
                'slug_alt' => 'history.tax.editar', 'short_description' => 'editar histórico de impuesto'
            ],
            [
                'name' => 'Eliminar histórico de impuestos', 'slug' => 'history.tax.delete',
                'description' => 'Acceso para eliminar histórico de impuestos',
                'model' => HistoryTax::class, 'model_prefix' => '0general',
                'slug_alt' => 'history.tax.eliminar', 'short_description' => 'eliminar histórico de impuesto'
            ],
            [
                'name' => 'Ver histórico de impuestos', 'slug' => 'history.tax.list',
                'description' => 'Acceso para ver histórico de impuestos',
                'model' => HistoryTax::class, 'model_prefix' => '0general',
                'slug_alt' => 'history.tax.ver', 'short_description' => 'ver histórico de impuestos'
            ],
            [
                'name' => 'Notificar gestión de histórico de impuestos',
                'slug' => 'history.tax.notify',
                'description' => 'Notificar sobre gestión de datos de histórico de impuestos',
                'model' => HistoryTax::class, 'model_prefix' => '0general',
                'slug_alt' => 'history.tax.notificar',
                'short_description' => 'notificar la gestión de histórico de impuestos'
            ],
        ]);

        /** @var array Permisos para la gestión de sectores de instituciones */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear sectores de instituciones', 'slug' => 'institution.sector.create',
                'description' => 'Acceso al registro de sectores de instituciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.sector.crear', 'short_description' => 'agregar sector de institución'
            ],
            [
                'name' => 'Editar sectores de instituciones', 'slug' => 'institution.sector.edit',
                'description' => 'Acceso para editar sectores de instituciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.sector.editar', 'short_description' => 'editar sector de institución'
            ],
            [
                'name' => 'Eliminar sectores de instituciones', 'slug' => 'institution.sector.delete',
                'description' => 'Acceso para eliminar sectores de instituciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.sector.eliminar', 'short_description' => 'eliminar sector de institución'
            ],
            [
                'name' => 'Ver sectores de instituciones', 'slug' => 'institution.sector.list',
                'description' => 'Acceso para ver sectores de instituciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.sector.ver', 'short_description' => 'ver sectores de instituciones'
            ],
            [
                'name' => 'Notificar gestión de sectores de instituciones',
                'slug' => 'institution.sector.notify',
                'description' => 'Notificar sobre gestión de datos de sectores de instituciones',
                'model' => InstitutionSector::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.sector.notificar',
                'short_description' => 'notificar la gestión de sectores de instituciones'
            ],
        ]);

        /** @var array Permisos para la gestión de tipos de instituciones */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear tipos de instituciones', 'slug' => 'institution.type.create',
                'description' => 'Acceso al registro de tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.tipo.crear', 'short_description' => 'agregar tipo de institución'
            ],
            [
                'name' => 'Editar tipos de instituciones', 'slug' => 'institution.type.edit',
                'description' => 'Acceso para editar tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.tipo.editar', 'short_description' => 'editar tipo de institución'
            ],
            [
                'name' => 'Eliminar tipos de instituciones', 'slug' => 'institution.type.delete',
                'description' => 'Acceso para eliminar tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.tipo.eliminar', 'short_description' => 'eliminar tipo de institución'
            ],
            [
                'name' => 'Ver tipos de instituciones', 'slug' => 'institution.type.list',
                'description' => 'Acceso para ver tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.tipo.ver', 'short_description' => 'ver tipos de instituciones'
            ],
            [
                'name' => 'Notificar gestión de tipos de instituciones',
                'slug' => 'institution.type.notify',
                'description' => 'Notificar sobre gestión de datos de tipos de instituciones',
                'model' => InstitutionType::class, 'model_prefix' => '0general',
                'slug_alt' => 'institution.tipo.notificar',
                'short_description' => 'notificar la gestión de tipos de instituciones'
            ],
        ]);

        /** @var array Permisos para la gestión de estados civiles */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear estado civil', 'slug' => 'marital.status.create',
                'description' => 'Acceso al registro de estados civiles',
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.crear', 'short_description' => 'agregar estados civiles'
            ],
            [
                'name' => 'Editar estado civil', 'slug' => 'marital.status.edit',
                'description' => 'Acceso para editar estados civiles',
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.editar', 'short_description' => 'editar estados civiles'
            ],
            [
                'name' => 'Eliminar estado civil', 'slug' => 'marital.status.delete',
                'description' => 'Acceso para eliminar estados civiles',
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.eliminar', 'short_description' => 'eliminar estados civiles'
            ],
            [
                'name' => 'Ver estado civil', 'slug' => 'marital.status.list',
                'description' => 'Acceso para ver estados civiles',
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.ver', 'short_description' => 'ver estados civiles'
            ],
            [
                'name' => 'Notificar gestión de estados civiles',
                'slug' => 'marital.status.notify',
                'description' => 'Notificar sobre gestión de datos de estados civiles',
                'model' => MaritalStatus::class, 'model_prefix' => '0general',
                'slug_alt' => 'estado.civil.notificar',
                'short_description' => 'notificar la gestión de estados civiles'
            ],
        ]);

        /** @var array Permisos para la gestión de unidades de medida */
        $permissions = array_merge($permissions, [
            [
                'name' => 'Crear unidad de medida', 'slug' => 'measurement.unit.create',
                'description' => 'Acceso al registro de unidades de medida',
                'model' => MeasurementUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.medida.crear', 'short_description' => 'agregar unidades de medida'
            ],
            [
                'name' => 'Editar unidad de medida', 'slug' => 'measurement.unit.edit',
                'description' => 'Acceso para editar unidades de medida',
                'model' => MeasurementUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.medida.editar', 'short_description' => 'editar unidades de medida'
            ],
            [
                'name' => 'Eliminar unidad de medida', 'slug' => 'measurement.unit.delete',
                'description' => 'Acceso para eliminar unidades de medida',
                'model' => MeasurementUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.medida.eliminar', 'short_description' => 'eliminar unidades de medida'
            ],
            [
                'name' => 'Ver unidad de medida', 'slug' => 'measurement.unit.list',
                'description' => 'Acceso para ver unidades de medida',
                'model' => MeasurementUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.medida.ver', 'short_description' => 'ver unidades de medida'
            ],
            [
                'name' => 'Notificar gestión de unidades de medida',
                'slug' => 'measurement.unit.notify',
                'description' => 'Notificar sobre gestión de datos de unidades de medida',
                'model' => MeasurementUnit::class, 'model_prefix' => '0general',
                'slug_alt' => 'unidad.medida.notificar',
                'short_description' => 'notificar la gestión de unidades de medida'
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
