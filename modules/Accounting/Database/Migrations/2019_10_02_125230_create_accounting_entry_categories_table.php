<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingEntryCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entry_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->comment('Nombre de la categoria u origen del cual se genero el asiento contable');
            $table->text('acronym')->comment('acrónimo utilizado al generar un asiento de manera automatica');
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
        Schema::dropIfExists('accounting_entry_categories');
    }
}
