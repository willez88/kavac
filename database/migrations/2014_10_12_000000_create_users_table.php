<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('username', 20)->comment('nombre de usuario para acceso al sistema');
                $table->string('password')->comment('Contraseña cifrada');
                $table->integer('level')->unsigned()->default(0)
                      ->comment('Nivel de acceso del usuario. (0) usuario, (1) administrador');
                $table->timestamp('last_login')->nullable()->comment('Último acceso registrado');
                $table->boolean('lock_screen')->default(false)
                      ->comment('Bloquea o desbloquea la pantalla para una sesión activa');
                $table->integer('time_lock')->unsigned()->default(10)
                      ->comment('Tiempo máximo de inactividad para el bloqueo de pantalla');
                $table->text('sign_public_key')->nullable()
                      ->comment('Clave pública para la verificación de firma de documentos');
                $table->boolean('active')->default(true)
                      ->comment('Estatus actual del usuario. (False) inactivo, (True) activo');
                $table->timestamp('email_verified_at')->nullable()
                      ->comment('validación para determinar si la dirección de correo fue verificada');
                $table->datetime('blocked_at')->nullable()->comment('fecha en la que fue bloqueado un usuario');
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
