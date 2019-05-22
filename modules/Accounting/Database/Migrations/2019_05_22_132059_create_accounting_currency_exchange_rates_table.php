<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingCurrencyExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_currency_exchange_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id')->unsigned();
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->comment('id de la moneda');
                
            $table->float('value',30,10)
                                ->comment('Valor de la tasa de cambio, a la moneda por defecto.');

            $table->date('date')->nullable()->comment('Fecha de aplicación de cambio');

            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_currency_exchange_rates');
    }
}
