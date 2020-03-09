<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldPurchaseOrderIdToPurchaseRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirements', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirements', 'purchase_order_id')) {
                $table->dropColumn('purchase_order_id');
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
        Schema::table('purchase_requirements', function (Blueprint $table) {
            // se crea nuevamente copn dirección a la tabla purchase_order
            $table->integer('purchase_order_id')->unsigned()->nullable()
                      ->comment('identificador del registro de la orden de compra');
            $table->foreign('purchase_order_id')->references('id')
                      ->on('purchase_orders')->onDelete('cascade');
        });
    }
}
