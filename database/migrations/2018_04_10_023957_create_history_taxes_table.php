<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('history_taxes')) {
            Schema::create('history_taxes', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->date('operation_date')->comment('Fecha de entrada en vigencia del impuesto');
                $table->decimal('percentage', 5, 2)->comment('Porcentaje del impuesto');
                $table->integer('tax_id')->unsigned()
                      ->comment('Identificador asociado al impuesto');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->foreign('tax_id')->references('id')->on('taxes')->onUpdate('cascade');
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
        Schema::dropIfExists('history_taxes');
    }
}
