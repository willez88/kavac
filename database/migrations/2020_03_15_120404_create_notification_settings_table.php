<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notification_settings')) {
            Schema::create('notification_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('module')->nullable()
                      ->comment(
                          <<<EOT
                          Nombre del módulo que genera la notificación. Por defecto es nulo para notificaciones
                          provenientes de la aplicación base
                          EOT
                      );
                $table->string('model')->unique()->comment('Nombre de la clase del modelo que genera una notificación');
                $table->string('name')->comment('Nombre de la notificación a configurar');
                $table->string('slug')->unique()->comment('Slug de la notificación a configurar');
                $table->string('description')->comment('Descripción de la notificación a configurar');
                $table->string('message')->comment('Mensaje de la notificación');
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
        Schema::dropIfExists('notification_settings');
    }
}
