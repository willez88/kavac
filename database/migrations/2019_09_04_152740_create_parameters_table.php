<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('parameters')) {
            Schema::create('parameters', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('p_key')->comment('Clave de referencia para el parámetro');
                $table->longText('p_value')->comment('Valor establecido para el parámetro');
                $table->string('required_by')->default('core')->comment(
                    'Indica quien requiere del parámetro (aplicación base o módulo). ' .
                    'Por defecto se establece la aplicación base, para modulos se debe indicar el nombre del mismo'
                );
                $table->boolean('active')->default(true)->comment(
                    'Indica si el parámetro se encuentra activo o no. El valor por defecto es activo.'
                );
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['p_key', 'required_by'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('parameters');
    }
}
