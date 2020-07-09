<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseBaseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_base_budgets')){
            Schema::create('purchase_base_budgets', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->integer('currency_id')->unsigned()->nullable()
                      ->comment('Unidad monetaria en la que se expresara el presupuesto base.');

                $table->float('subtotal', 12, 10)->nullable()
                          ->comment('Subtotal del registro de presupuesto base');

                $table->enum('status', ['WAIT', 'QUOTED', 'WAIT_QUOTATION', 'BOUGHT'])->default('WAIT')
                          ->comment(
                              'Determina el estatus del presupuesto base 
                              (WAIT) - espera por ser completado. 
                              (WAIT_QUOTATION) - espera ser cotizado. 
                              (QUOTED) - Cotizado,
                              (BOUGHT) - comprado',
                          );
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
        Schema::dropIfExists('purchase_base_budgets');
    }
}
