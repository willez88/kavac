<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCurrencyBaseToAccountingCurrencyExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_currency_exchange_rates', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_currency_exchange_rates', 'currency_base_id')) {
                $table->integer('currency_base_id')->unsigned();
                $table->foreign('currency_base_id')->references('id')
                      ->on('currencies')->onDelete('cascade')
                      ->comment('id de la moneda base a la que se cotiza');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_currency_exchange_rates', function (Blueprint $table) {
            $table->dropForeign('accounting_currency_exchange_rates_currency_base_id_foreign');
            $table->dropColumn('currency_base_id');
        });
    }
}
