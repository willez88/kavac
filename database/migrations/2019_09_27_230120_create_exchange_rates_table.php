<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('exchange_rates')) {
            Schema::create('exchange_rates', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('start_at')->comment('Fecha a partil de la cual entra en vigencia la conversión');
                $table->date('end_at')->nullable()
                      ->comment('Fecha a partir de la cual dejo de estar en vigencia la conversión');
                $table->float('amount', 20, 2)->comment('Monto de la conversión');
                $table->boolean('active')->default(false)->comment('Indica si el tipo de cambio se encuentra activo');
                $table->unsignedBigInteger('from_currency_id')->comment(
                    'Identificador asociado a la moneda desde la cual realizar la conversión'
                );
                $table->foreign('from_currency_id')->references('id')
                      ->on('currencies')->onUpdate('cascade')->onDelete('restrict');
                $table->unsignedBigInteger('to_currency_id')->comment(
                    'Identificador asociado a la moneda a la cual realizar la conversión'
                );
                $table->foreign('to_currency_id')->references('id')
                      ->on('currencies')->onUpdate('cascade')->onDelete('restrict');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
                $table->unique(['start_at', 'end_at', 'active'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('exchange_rates');
    }
}
