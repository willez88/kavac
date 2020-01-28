<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitPriceToPurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirement_items', 'unit_price')) {
                $table->integer('unit_price')->nullable()
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
        Schema::table('purchase_requirement_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requirement_items', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
        });
    }
}
