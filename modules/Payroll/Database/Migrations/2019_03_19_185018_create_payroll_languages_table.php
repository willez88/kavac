<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_languages')) {
            Schema::create('payroll_languages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 100)->comment('Nombre del idioma');
                $table->string('acronym', 10)->comment('Acrónimo del idioma');
                $table->integer('payroll_language_level_id')->unsigned()
                      ->comment('identificador de nivel de idioma que pertenece al idioma');
                $table->foreign('payroll_language_level_id')->references('id')->on('payroll_language_levels')
                      ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('payroll_languages');
    }
}
