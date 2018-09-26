<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

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
        
        /**
         * Permisos disponibles para la gestión de estatus de documentos
         */

        $permissions = [
        	[
        		'name' => 'Ver Logs del sistema', 'slug' => 'log.list',
        		'description' => 'Acceso para ver bitácoras de registros del sistema',
        		'model' => '\Venturecraft\Revisionable\Revision', 'model_prefix' => '0general',
        		'slug_alt' => 'log.list', 'short_description' => 'ver logs del sistema'
        	],
        	[
        		'name' => 'Restaurar registros del sistema', 'slug' => 'record.undelete',
        		'description' => 'Acceso para restaurar registros del sistema',
        		'model' => 'Illuminate\Database\Eloquent\SoftDeletes', 'model_prefix' => '0general',
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
        		'model' => 'App\User', 'model_prefix' => '0general', 
        		'slug_alt' => 'usuario.configurar', 'short_description' => 'configurar usuarios'
        	],
        	[
        		'name' => 'Enviar Notificaciones a usuarios', 'slug' => 'user.notification.send',
        		'description' => 'Acceso para enviar notificaciones a usuarios',
        		'model' => 'App\User', 'model_prefix' => '0general', 
        		'slug_alt' => 'usuario.notificacion.enviar', 
        		'short_description' => 'enviar notificaciones a usuarios'
        	],
        	[
        		'name' => 'Ver información de usuarios', 'slug' => 'user.info',
        		'description' => 'Acceso ver información de usuarios',
        		'model' => 'App\User', 'model_prefix' => '0general', 
        		'slug_alt' => 'usuario.informacion', 
        		'short_description' => 'ver información de usuarios'
        	],
        	[
        		'name' => 'Asignar / Revocar permisos a usuarios', 'slug' => 'user.permissions',
        		'description' => 'Acceso para asignar o revocar permisos a usuarios',
        		'model' => 'App\User', 'model_prefix' => '0general', 
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
        		'model' => '\Venturecraft\Revisionable\Revision', 'model_prefix' => '0general', 
        		'slug_alt' => 'historico.ver', 'short_description' => 'ver historico personal'
        	],
        	[
        		'name' => 'Configurar parámetros generales', 'slug' => 'system.param.setting',
        		'description' => 'Acceso para configurar parámetros generales del sistema',
        		'model' => 'App\Models\Setting', 'model_prefix' => '0general', 
        		'slug_alt' => 'sistema.parametro.configurar', 
        		'short_description' => 'configurar parámetros generales'
        	],
        	[
        		'name' => 'Configurar Instituciones', 'slug' => 'institution.setting',
        		'description' => 'Acceso para configurar datos de Instituciones',
        		'model' => 'App\Models\Institution', 'model_prefix' => '0general', 
        		'slug_alt' => 'institucion.configurar', 
        		'short_description' => 'configurar instituciones'
        	],
        ];

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
    }
}
