<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequirementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requirement_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Nombre del producto a solicitar para su compra');
            $table->string('description')->nullable()->comment('descripción del producto a solicitar');
            $table->longText('technical_specifications')->nullable()
                  ->comment('Especificaciones técnicas del producto a requerir. Opcional');
            $table->float('quantity')->default(1)->comment("Cantidad del producto a solicitar");

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación del producto
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación al producto
            */
            $table->integer('measurement_unit_id')->unsigned()
                  ->comment('Identificador de la unidad de medida');
            $table->foreign('measurement_unit_id')->references('id')
                  ->on('measurement_units')->onDelete('restrict')
                  ->onUpdate('cascade');

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación del producto
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación al producto
            */
            $table->integer('warehouse_product_id')->unsigned()->nullable()
                  ->comment(
                    'Identificador del producto a solicitar para su compra si ya existe un producto registrado con las mismas características'
                  );
            $table->foreign('warehouse_product_id')->references('id')
                  ->on('warehouse_products')->onDelete('restrict')
                  ->onUpdate('cascade');

            /*
            * -----------------------------------------------------------------------
            * Clave foránea a la relación del requerimiento
            * -----------------------------------------------------------------------
            *
            * Define la estructura de relación al requerimiento
            */
            $table->integer('purchase_requirement_id')->unsigned()
                  ->comment('Identificador del requerimiento de compra');
            $table->foreign('purchase_requirement_id')->references('id')
                  ->on('purchase_requirements')->onDelete('restrict')
                  ->onUpdate('cascade');

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
        Schema::dropIfExists('purchase_requirement_items');
    }
}