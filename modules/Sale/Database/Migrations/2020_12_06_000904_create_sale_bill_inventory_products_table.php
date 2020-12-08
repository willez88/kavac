<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleBillInventoryProductsTable
 * @brief Crear tabla de los productos asociados a una solicitud de almacén
 *
 * Gestiona la creación o eliminación de la tabla de productos asociados a una solicitud de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class CreateSaleBillInventoryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_bill_inventory_products')) {
            Schema::create('sale_bill_inventory_products', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->integer('quantity')->unsigned()->comment('Cantidad solicitada del producto');

                $table->unsignedBigInteger('sale_bill_id')->nullable()
                      ->comment('Identificador único de la factura');
                $table->foreign(
                    'sale_bill_id',
                    'sale_bill_inventory_products_warehouse_bill_fk'
                )->references('id')->on('sale_bills')->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_warehouse_inventory_product_id')->nullable()
                      ->comment('Identificador único del producto solicitado en el inventario');
                $table->foreign(
                    'sale_warehouse_inventory_product_id',
                    'sale_bill_inventory_products_inventory_product_fk'
                )->references('id')->on('sale_warehouse_inventory_products')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('sale_bill_inventory_products');
    }
}
