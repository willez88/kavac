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
        Schema::create('payroll_nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('demonym', 100)->comment('Nacionalidad');
            $table->integer('country_id')->unsigned()
                  ->comment('identificador del país al que pertenece la nacionalidad');
            $table->unique('country_id')->comment('Clave única para el registro');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
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
