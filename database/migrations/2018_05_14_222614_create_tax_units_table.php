<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tax_units')) {
            Schema::create('tax_units', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->float('value', 20, 2)->comment('Valor de la unidad tributaria');
                $table->date('start_date')
                      ->comment('Fecha de entrada en vigencia de la unidad tributaria');
                $table->date('end_date')->nullable()
                      ->comment('Fecha hasta la que estivo vigente la unidad tributaria');
                $table->boolean('active')->default(true)
                      ->comment('Indica si la unidad tributaria esta activo');
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->timestamps();
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
        Schema::dropIfExists('tax_units');
    }
}
