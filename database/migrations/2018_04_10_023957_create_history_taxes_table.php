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
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->date('operation_date')->comment('Fecha de entrada en vigencia del impuesto');
                $table->decimal('percentage', 5, 2)->comment('Porcentaje del impuesto');
                $table->foreignId('tax_id')->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('history_taxes');
    }
}
