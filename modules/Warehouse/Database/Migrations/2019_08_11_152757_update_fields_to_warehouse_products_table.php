<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseProductsTable
 * @brief Actualiza los campos de la tabla de productos almacenables
 *
 * Gestiona la actualización de los campos de la tabla de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseProductsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_products', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_products', 'name')) {
                $table->string('name', 100)->nullable()->comment('Nombre del producto')->change();
            }
            if (Schema::hasColumn('warehouse_products', 'description')) {
                $table->text('description')->nullable()->comment('Descripción del producto')->change();
            }
            if (Schema::hasColumn('warehouse_products', 'attribute')) {
                $table->renameColumn('attribute', 'define_attributes');
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
        Schema::table('warehouse_products', function (Blueprint $table) {
        });
    }
}
