<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_product_attributes')) {    
            Schema::create('warehouse_product_attributes', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('name')->nullable()->comment('Nombre o descripción del atributo o característica específica del producto');

                $table->integer('product_id')->comment('Identificador único del producto');
                $table->foreign('product_id')->references('id')->on('warehouse_products')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('warehouse_product_attributes');
    }
}
