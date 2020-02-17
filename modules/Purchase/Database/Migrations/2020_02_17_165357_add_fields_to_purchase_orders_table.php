<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_orders', 'purchase_requirement_item_id')) {
                $table->integer('purchase_requirement_item_id')->unsigned()->nullable()
                      ->comment('Llave foranea a un producto en un requerimiento');
                $table->foreign('purchase_requirement_item_id')->references('id')
                      ->on('purchase_requirement_items')->onDelete('cascade')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('purchase_orders', 'purchase_requirement_id')) {
                $table->integer('purchase_requirement_id')->unsigned()->nullable()
                      ->comment('Llave foranea a un producto en un requerimiento');
                $table->foreign('purchase_requirement_id')->references('id')
                      ->on('purchase_requirement_items')->onDelete('cascade')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('purchase_orders', 'unit_price')) {
                $table->float('unit_price', 10, 10)->nullable()
                      ->comment('Precio unitario del producto o servicio. asignado en presupuesto base');
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
        Schema::table('purchase_orders', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_orders', 'purchase_requirement_item_id')) {
                $table->dropColumn('purchase_requirement_item_id');
            }

            if (Schema::hasColumn('purchase_orders', 'purchase_requirement_id')) {
                $table->dropColumn('purchase_requirement_id');
            }
            
            if (Schema::hasColumn('purchase_orders', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
        });
    }
}
