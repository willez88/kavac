<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('estates')) {
            Schema::create('estates', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 100)->comment('Nombre del Estado');
                $table->string('code', 10)->nullable()->comment('Código que identifica al Estado');
                $table->integer('country_id')->unsigned()
                      ->comment('Identificador del Pais al que pertenece el Estado');
                $table->foreign('country_id')->references('id')
                      ->on('countries')->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['country_id', 'name'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('estates');
    }
}
