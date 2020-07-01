<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_orders')){
            Schema::create('purchase_orders', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('purchase_supplier_id')->unsigned()->nullable()
                      ->comment('identificador del registro del proveedor');
                $table->foreign('purchase_supplier_id')->references('id')
                      ->on('purchase_suppliers')->onDelete('restrict')
                      ->onUpdate('cascade');
                $table->integer('currency_id')->unsigned()->nullable()
                      ->comment('identificador del registro del tipo de moneda');
                $table->foreign('currency_id')->references('id')
                      ->on('currencies')->onDelete('restrict')
                      ->onUpdate('cascade');
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
        Schema::dropIfExists('purchase_orders');
    }
}
