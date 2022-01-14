<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiscalYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fiscal_years')) {
            Schema::create('fiscal_years', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('year', 4)->unique()->comment('Año fiscal');
                $table->boolean('active')->default(true)->comment('Estatus del año fiscal');
                $table->text('observations')->nullable()->comment('Observaciones al año fiscal');
                $table->boolean('closed')->default(false)
                      ->comment('Establece si el año de ejercicio fiscal ya fue cerrado');
                $table->foreignId('institution_id')->nullable()->constrained()
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
        Schema::dropIfExists('fiscal_years');
    }
}
