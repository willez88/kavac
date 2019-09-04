<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseInventoryProductMovementsTable
 * @brief Crear tabla de los productos asociados a un movimiento de almacén
 *
 * Gestiona la creación y eliminación de la tabla de productos asociados a un movimiento de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseInventoryProductMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventory_product_movements')) {
            Schema::create('warehouse_inventory_product_movements', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('quantity')->unsigned()->comment('Cantidad del producto movilizado');
                $table->float('new_value')->comment('Nuevo precio del producto movilizado');

                $table->integer('warehouse_movement_id')->unsigned()
                      ->comment('Identificador único del movimiento de almacén realizado');
                $table->foreign('warehouse_movement_id')->references('id')->on('warehouse_movements')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_initial_inventory_product_id')->nullable()->unsigned()
                      ->comment('Identificador único de la ubicación inicial del producto en el inventario');
                $table->foreign('warehouse_initial_inventory_product_id')->references('id')
                      ->on('warehouse_inventory_products')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_inventory_product_id')->unsigned()
                      ->comment('Identificador único del producto en el inventario');
                $table->foreign('warehouse_inventory_product_id')->references('id')
                      ->on('warehouse_inventory_products')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('warehouse_inventory_product_movements');
    }
}
