<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseRequestProductTable
 * @brief Crear tabla de Productos Solicitados al Almacén
 * 
 * Gestiona las cantidades de los productos almacenables solicitados
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateWarehouseRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_request_products')) {
            Schema::create('warehouse_request_products', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('quantity')->comment('Cantidad solicitada del producto');

                $table->integer('product_id')->comment('Identificador único del producto solicitado en la tala warehouse_products');
                $table->foreign('product_id')->references('id')->on('warehouse_inventary_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('unit_id')->comment('Identificador único de la unidad métrica del producto solicitado en la tala warehouse_product_units');
                $table->foreign('unit_id')->references('id')->on('warehouse_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_id')->comment('Identificador único del almacén al que se le solicita el producto en la tabla warehouses');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();

                /*
                 * Fecha y hora en la que fue elimidado el registro
                 */
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
        Schema::dropIfExists('warehouse_request_products');
    }
}
