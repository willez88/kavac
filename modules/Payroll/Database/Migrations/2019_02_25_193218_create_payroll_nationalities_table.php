<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_nationalities')) {
            Schema::create('payroll_nationalities', function (Blueprint $table) {
                $table->increments('id');
                $table->string('demonym', 100)->comment('Gentilicio');
                $table->integer('country_id')->unsigned()
                      ->comment('identificador del país al que pertenece el gentilicio');
                $table->foreign('country_id')->references('id')->on('countries')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->unique('country_id')->comment('Clave única para el registro');
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
        Schema::dropIfExists('payroll_nationalities');
    }
}
