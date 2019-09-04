<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('measurement_units')) {
            Schema::create('measurement_units', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre de la unidad de medida');
                $table->text('description')->comment('Descripción de la unidad de medida');
                $table->string('acronym', 6)->comment('Acrónimo o abreviatura de la unidad de medida');
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
        Schema::dropIfExists('measurement_units');
    }
}
