<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('code_settings')) {
            Schema::create('code_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('module')->nullable()->comment('Nombre del módulo si aplica');
                $table->string('model')->comment('Namespace del modelo donde aplica la configuración');
                $table->string('table')->comment('Tabla en donde se aplicará la configuración del código');
                $table->string('field')->default('code')
                      ->comment(
                          'Nombre del campo que registrará el código configurado. El campo por defecto es "code"'
                      );
                $table->boolean('active')->default(true)->comment('Indica si la configuración esta activa');
                $table->string('format_prefix', 3)->comment('Formato del prefijo configurado');
                $table->string('format_digits', 8)->comment('Formato de los dígitos configurados');
                $table->enum('format_year', ['YY', 'YYYY'])->comment('Formato del prefijo configurado');
                $table->text('description')->nullable()->comment('Descripción de la configuración del código');
                $table->string('type')->nullable()
                      ->comment(
                          "Define un tipo de registro en caso de que en un mismo modelo se registre " .
                          "distinta información"
                      );
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique([
                    'module', 'table', 'field', 'active', 'format_prefix', 'format_digits', 'format_year'
                ], 'code_settings_unique_id')->comment('Clave única para el registro');
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
        Schema::dropIfExists('code_settings');
    }
}
