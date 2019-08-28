<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddAbbreviationToWarehouseProductUnitsTable
 * @brief Agrega el campo abreviatura a la tabla de unidades de medida de los productos
 *
 * Gestiona la agregación el campo abreviatura a la tabla de unidades de medida de los productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddAbbreviationToWarehouseProductUnitsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_product_units', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_product_units', 'abbreviation')) {
                $table->string('abbreviation', 4)->comment('Abreviatura de la unidad métrica');
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
        Schema::table('warehouse_product_units', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
        });
    }
}
