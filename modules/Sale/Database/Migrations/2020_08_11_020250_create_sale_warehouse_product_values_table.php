<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleWarehouseProductValuesTable
 * @brief Crear tabla de valores de atributos de los prductos
 *
 * Gestiona la creación o eliminación de la tabla de valores de atributos de los productos almacenables
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseProductValuesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_product_values')) {
            Schema::create('sale_warehouse_product_values', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('value', 100)->comment('Valor o descripción del atributo');

                //$table->foreignId('sale_warehouse_inventory_product_id')->constrained()
                //      ->onDelete('restrict')->onUpdate('cascade');
                $table->unsignedBigInteger('sale_warehouse_inventory_product_id');

                $table->foreign('sale_warehouse_inventory_product_id', 'sale_warehouse_product_values_inventory_fk')
                      ->references('id')->on('sale_setting_products');

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
        Schema::dropIfExists('sale_warehouse_product_values');
    }
}
