<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleWarehouseInventoryProductsTable
 * @brief Crear tabla de inventario de productos
 *
 * Gestiona la creación o eliminación de la tabla de inventario de productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseInventoryProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_inventory_products')) {
            Schema::create('sale_warehouse_inventory_products', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del producto en el inventario');
                $table->integer('exist')->unsigned()->nullable()
                      ->comment('Cantidad de productos en existencia, incluye los reservados por solicitudes almacén');
                $table->integer('reserved')->unsigned()->nullable()
                      ->comment('Cantidad de productos reservados por solicitudes de almacén');
                $table->float('unit_value')->unsigned()->comment('Valor por unidad del producto en el almacén');

                $table->foreignId('currency_id')->nullable()->constrained()->onUpdate('cascade');

                //$table->foreignId('sale_setting_products_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_setting_products_id');

                $table->foreign('sale_setting_products_id', 'sale_warehouse_inventory_products_setting_fk')
                      ->references('id')->on('sale_setting_products');

                $table->foreignId('measurement_unit_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_warehouse_institution_warehouse_id')->nullable()
                      ->comment('Identificador único de la institución que gestiona el almacén donde está el producto');
                $table->foreign(
                    'sale_warehouse_institution_warehouse_id',
                    'sale_warehouse_inventory_products_institution_warehouse_pk'
                )->references('id')->on(
                    'sale_warehouse_institution_warehouses'
                )->onDelete('restrict')->onUpdate('cascade');


                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('sale_warehouse_inventory_products');
    }
}
