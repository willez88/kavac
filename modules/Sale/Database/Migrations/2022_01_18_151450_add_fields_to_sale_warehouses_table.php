<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsToSaleWarehousesTable
 * @brief Agrega campos a la tabla de almacenes de comercialización
 *
 * Gestiona la creación o eliminación de los campos agregados a la table de almacenes
 * de comercialización
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsToSaleWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('sale_warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_warehouses', 'country_id')) {
                $table->foreignId('country_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('sale_warehouses', 'estate_id')) {
                $table->foreignId('estate_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('sale_warehouses', 'municipality_id')) {
                $table->foreignId('municipality_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que revierte las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('sale_warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('sale_warehouses', 'country_id')) {
                $table->dropForeign('sale_warehouses_country_id_foreign');
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('sale_warehouses', 'estate_id')) {
                $table->dropForeign('sale_warehouses_estate_id_foreign');
                $table->dropColumn('estate_id');
            }
            if (Schema::hasColumn('sale_warehouses', 'municipality_id')) {
                $table->dropForeign('sale_warehouses_municipality_id_foreign');
                $table->dropColumn('municipality_id');
            }
        });
    }
}
