<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseInventoryProductsTable
 * @brief Actualiza los campos de la tabla de inventario de productos
 *
 * Gestiona la actualización de los campos de la tabla de inventario de productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseInventoryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('warehouse_inventary_rules');
        Schema::dropIfExists('warehouse_product_values');
        Schema::dropIfExists('warehouse_inventary_products');
        Schema::dropIfExists('warehouse_product_units');
        
        if (!Schema::hasTable('warehouse_inventory_products')) {
            Schema::create('warehouse_inventory_products', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del producto en el inventario');
                $table->integer('exist')->unsigned()->nullable()
                      ->comment('Cantidad de productos en existencia, incluye los reservados por solicitudes almacén');
                $table->integer('reserved')->unsigned()->nullable()
                      ->comment('Cantidad de productos reservados por solicitudes de almacén');
                $table->float('unit_value')->unsigned()->comment('Valor por unidad del producto en el almacén');

                $table->integer('currency_id')->unsigned()->nullable()
                      ->comment('Identificador único asociado a la moneda');
                $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade');

                $table->integer('warehouse_product_id')->unsigned()->comment('Identificador único del producto');
                $table->foreign('warehouse_product_id')->references('id')->on('warehouse_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('measurement_unit_id')->unsigned()
                      ->comment('Identificador único de la unidad de medida del producto');
                $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_institution_warehouse_id')->nullable()
                      ->comment('Identificador único de la institución que gestiona el almacén donde está el producto');
                $table->foreign('warehouse_institution_warehouse_id')->references('id')
                      ->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::table('warehouse_inventory_products', function (Blueprint $table) {
        });
    }
}
