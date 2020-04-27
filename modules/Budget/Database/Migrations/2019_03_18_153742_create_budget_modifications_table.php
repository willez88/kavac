<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_modifications')) {
            Schema::create('budget_modifications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('approved_at')
                      ->comment("Fecha en la que se aprobó la modificación presupuestaria");
                $table->string('code', 20)->unique()
                      ->comment('Código único para el tipo de modifición presupuestaria');
                $table->enum('type', ['C', 'R', 'T'])
                      ->comment('Tipo de operación: (C)rédito, (R)educción o (T)raspaso');
                $table->text('description')
                      ->comment('Descripción del documento que avala la modificación presupuestaria');
                $table->string('document')
                      ->comment('Número del documento que avala la modificación presupuestaria');
                $table->bigInteger('institution_id')->unsigned()
                      ->comment('Identificador asociado a la institución');
                $table->foreign('institution_id')->references('id')->on('institutions')->onUpdate('cascade');
                $table->bigInteger('document_status_id')->unsigned()
                      ->comment('Identificador asociado a la institución');
                $table->foreign('document_status_id')->references('id')
                      ->on('document_status')->onUpdate('cascade');
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
        Schema::dropIfExists('budget_modifications');
    }
}
