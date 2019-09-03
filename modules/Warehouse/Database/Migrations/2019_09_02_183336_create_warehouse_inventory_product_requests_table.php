<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseInventoryProductRequestsTable
 * @brief Crear tabla de los productos asociados a una solicitud de almacén
 *
 * Gestiona la creación o eliminación de la tabla de productos asociados a una solicitud de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseInventoryProductRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventory_product_requests')) {
            Schema::create('warehouse_inventory_product_requests', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('quantity')->unsigned()->comment('Cantidad solicitada del producto');

                $table->integer('warehouse_request_id')->nullable()->unsigned()
                      ->comment('Identificador único de la solicitud');
                $table->foreign('warehouse_request_id')->references('id')->on('warehouse_requests')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_inventory_product_id')->nullable()->unsigned()
                      ->comment('Identificador único del producto solicitado en el inventario');
                $table->foreign('warehouse_inventory_product_id')->references('id')->on('warehouse_inventory_products')
                      ->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('warehouse_inventory_product_requests');
    }
}
