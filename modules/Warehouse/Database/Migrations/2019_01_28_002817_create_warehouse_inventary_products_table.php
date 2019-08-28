<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseInventaryProductsTable
 * @brief Crear tabla de inventario de productos
 *
 * Gestiona la creación o eliminación de la tabla de inventario de productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseInventaryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventary_products')) {
            Schema::create('warehouse_inventary_products', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('exist')->unsigned()->nullable()
                      ->comment('Cantidad de artículos en existencia, incluye los reservados por solicitudes almacen');

                $table->integer('reserved')->unsigned()->nullable()
                      ->comment('Cantidad de artículos reservados por solicitudes de almacén');

                $table->integer('product_id')->unsigned()->comment('Identificador del registro en la tabla producto');
                $table->foreign('product_id')->references('id')->on('warehouse_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('unit_id')->unsigned()
                      ->comment('Identificador de la unidad métrica del producto en la tabla warehouse_units');
                $table->foreign('unit_id')->references('id')->on('warehouse_product_units')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_id')->unsigned()
                      ->comment('Identificador del almacen en el que esta inventariado el producto');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                      ->onDelete('restrict')->onUpdate('cascade');
                 
                $table->integer('unit_value')->unsigned()->nullable()
                      ->comment('Precio por unidad del artículo en el almacen');

                /**
                 * Fecha en la que se registra el articulo en el inventario de almacen
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_inventary_products');
    }
}
