<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseProductAttributesTable
 * @brief Actualiza los campos de la tabla de atributos de productos almacenables
 *
 * Gestiona la actualización de los campos de la tabla de atributos de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseProductAttributesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_product_attributes', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_product_attributes', 'name')) {
                $table->string('name', 100)->nullable()
                      ->comment('Nombre o descripción del atributo o característica específica del producto')->change();
            }
            if (Schema::hasColumn('warehouse_product_attributes', 'product_id')) {
                $table->dropForeign('warehouse_product_attributes_product_id_foreign');
                $table->renameColumn('product_id', 'warehouse_product_id');
                $table->foreign('warehouse_product_id')->references('id')->on('warehouse_products')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
        });
    }
}
