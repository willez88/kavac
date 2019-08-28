<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseRequestProductsTable
 * @brief Actualiza los campos de la tabla intermedia de productos-solicitudes
 *
 * Gestiona la actualización de los campos de la tabla intermedia de productos-solicitudes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseRequestProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('warehouse_request_products');
        
        if (!Schema::hasTable('warehouse_request_products')) {
            Schema::create('warehouse_request_products', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('quantity')->unsigned()->comment('Cantidad solicitada del producto');

                $table->integer('warehouse_request_id')->nullable()->comment('Identificador único de la solicitud');
                $table->foreign('warehouse_request_id')->references('id')->on('warehouse_requests')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_inventory_product_id')->nullable()
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
        Schema::table('warehouse_request_products', function (Blueprint $table) {
        });
    }
}
