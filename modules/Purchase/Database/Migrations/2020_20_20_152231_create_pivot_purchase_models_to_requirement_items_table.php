<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotPurchaseModelsToRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_pivot_models_to_requirement_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            if (!Schema::hasColumn('purchase_pivot_order_to_requirement_items', 'relatable_type')) {
                $table->morphs('relatable');
            }

            if (!Schema::hasColumn('purchase_pivot_order_to_requirement_items', 'purchase_requirement_item_id')) {
                $table->integer('purchase_requirement_item_id')->unsigned()
                      ->comment('Llave foranea a un producto en un requerimiento');
                $table->foreign('purchase_requirement_item_id')->references('id')
                      ->on('purchase_requirement_items')->onDelete('cascade')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('purchase_pivot_order_to_requirement_items', 'unit_price')) {
                $table->float('unit_price', 10, 10)->nullable()
                      ->comment('Precio unitario del producto o servicio. asignado en orden de compra');
            }

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_pivot_models_to_requirement_items');
    }
}
