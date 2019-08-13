<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('parishes')) {
            Schema::create('parishes', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre de la Parroquia');
                $table->string('code', 10)->nullable()->comment('Código que identifica a la Parroquia');
                $table->integer('municipality_id')->unsigned()
                      ->comment('Identificador asociado al Municipio al que pertenece');
                $table->foreign('municipality_id')->references('id')->on('municipalities')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['municipality_id', 'name'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('parishes');
    }
}
