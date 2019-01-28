<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseInventaryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventary_products')) {
            Schema::create('warehouse_inventary_products', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('exist')->unsigned()->comment('Cantidad de artículos en existencia en el almacen actualmente (Incluye a los reservados por solicitudes almacen)');

                $table->integer('reserved')->unsigned()->nullable()->comment('Cantidad de artículos reservados por solicitudes de almacen que se han registrado en el sistema');

                $table->integer('product_id')->unsigned()->comment('Identificador del artículo en la tabla producto');
                $table->foreign('product_id')->references('id')->on('warehouse_products')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_id')->unsigned()->comment('Identificador del almacen en el que esta inventariado el producto');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict')->onUpdate('cascade');
                 
                $table->integer('unit_value')->unsigned()->comment('Precio por unidad del artículo en el almacen');

                /**
                 * Fecha en la que se registra el articulo en el inventario de almacen
                 */
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
        Schema::dropIfExists('warehouse_inventary_products');
    }
}
