<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->comment('Nombre de la unidad, departamento o dependencia');
                $table->string('acronym', 4)
                      ->comment('Siglas de la unidad, departamento o dependencia');
                $table->integer('hierarchy')
                      ->comment('Jerarquía de la unidad, departamento o dependencia');
                $table->boolean('requisition')->default(true)
                      ->comment('Establece si puede generar requisiones de compras');
                $table->boolean('active')->default(true)
                      ->comment('Indica si se encuentra activa');
                $table->boolean('administrative')->default(false)
                      ->comment('Es una unidad, departamento o dependencia administrativa');
                $table->integer('institution_id')->unsigned()
                      ->comment('Identificador del Pais al que pertenece el Estado');
                $table->foreign('institution_id')->references('id')
                      ->on('institutions')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('departments');
    }
}
