<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingSeatCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('accounting_seat_categories')) {
            Schema::create('accounting_seat_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->text('name')->comment('Nombre de la categoria u origen del cual se genero el asiento contable');
                $table->text('acronym')->comment('acrónimo utilizado al generar un asiento de manera automatica');
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
        Schema::dropIfExists('accounting_seat_categories');
    }
}
