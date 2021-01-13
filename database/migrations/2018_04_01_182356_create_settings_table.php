<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->boolean('support')->default(false)->comment('Contacto con soporte técnico');
                $table->boolean('chat')->default(false)->comment('Comunicación interna por chat');
                $table->boolean('notify')->default(false)->comment('Notificaciones del sistema');
                $table->boolean('report_banner')->default(false)->comment('Banner en reportes');
                $table->boolean('multi_institution')->default(false)
                      ->comment('Gestión administrativa para múltiples organizaciones');
                $table->boolean('digital_sign')->default(false)->comment('Firma electrónica');
                $table->boolean('active')->default(true)->comment('Configuración actualmente activa');
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
        Schema::dropIfExists('settings');
    }
}
