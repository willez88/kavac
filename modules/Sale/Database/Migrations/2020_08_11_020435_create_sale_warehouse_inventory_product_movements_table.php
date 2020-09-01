<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleWarehouseInventoryProductMovementsTable
 * @brief Crear tabla de los productos asociados a un movimiento de almacén
 *
 * Gestiona la creación y eliminación de la tabla de productos asociados a un movimiento de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseInventoryProductMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_inventory_product_movements')) {
            Schema::create('sale_warehouse_inventory_product_movements', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->integer('quantity')->unsigned()->comment('Cantidad del producto movilizado');
                $table->float('new_value')->comment('Nuevo precio del producto movilizado');

                $table->unsignedBigInteger('sale_warehouse_movement_id')->comment(
                    'Identificador único del movimiento de almacén realizado'
                );
                $table->foreign(
                    'sale_warehouse_movement_id',
                    'sale_warehouse_inventory_product_movements_warehouse_movement_fk'
                )->references('id')->on('sale_warehouse_movements')->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_warehouse_initial_inventory_product_id')->nullable()
                      ->comment('Identificador único de la ubicación inicial del producto en el inventario');
                $table->foreign(
                    'sale_warehouse_initial_inventory_product_id',
                    'sale_warehouse_inventory_product_movements_initial_inventory_fk'
                )->references('id')->on('sale_warehouse_inventory_products')->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_warehouse_inventory_product_id')
                      ->comment('Identificador único del producto en el inventario');
                $table->foreign(
                    'sale_warehouse_inventory_product_id',
                    'sale_warehouse_inventory_product_movements_inventory_product_fk'
                )->references('id')->on('sale_warehouse_inventory_products')->onDelete('restrict')->onUpdate('cascade');


                $table->timestamps();
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_warehouse_inventory_product_movements');
    }
}
