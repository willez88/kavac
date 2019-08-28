<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseProductValuesTable
 * @brief Crear tabla de valores de atributos de los prductos
 *
 * Gestiona la creación o eliminación de la tabla de valores de atributos de los productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseProductValuesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_product_values')) {
            Schema::create('warehouse_product_values', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('value')->nullable()->comment('Valor o descripción del atributo');

                $table->integer('attribute_id')
                      ->comment('Identificador único del atributo en la tabla de atributos de productos');
                $table->foreign('attribute_id')->references('id')->on('warehouse_product_attributes')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('inventary_id')->unsigned()->nullable()
                      ->comment('Identificador del registro en la tabla de inventarios de almacen');
                $table->foreign('inventary_id')->references('id')->on('warehouse_inventary_products')
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
        Schema::dropIfExists('warehouse_product_values');
    }
}
