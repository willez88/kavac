<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('symbol', 4)->comment('Símbolo de la moneda');
                $table->string('name', 40)->comment('Nombre de la moneda');
                $table->boolean('default')->default(false)->comment('Moneda por defecto');
                $table->integer('decimal_places')->default(2)
                      ->comment('Máximo número de decimales a gestionar. El máximo es 10');
                $table->foreignId('country_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('currencies');
    }
}
