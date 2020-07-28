<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasePivotModelsToRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_pivot_models_to_requirement_items')){
            Schema::create('purchase_pivot_models_to_requirement_items', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->morphs('relatable');

                $table->foreignId('purchase_requirement_item_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->float('unit_price', 10, 10)->nullable()
                              ->comment('Precio unitario del producto o servicio. asignado en orden de compra');

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
        Schema::dropIfExists('purchase_pivot_models_to_requirement_items');
    }
}
