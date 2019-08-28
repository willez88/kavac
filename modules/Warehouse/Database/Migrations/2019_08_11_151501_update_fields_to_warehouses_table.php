<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehousesTable
 * @brief Actualiza los campos de la tabla almacenes
 *
 * Gestiona la actualización de los campos de la tabla almacenes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('name', 100)->comment('Nombre o descripción del almacen')->change();
            $table->text('address')->comment('Dirección física del almacen')->change();

            if (Schema::hasColumn('warehouses', 'country_id')) {
                $table->dropForeign('warehouses_country_id_foreign');
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('warehouses', 'estate_id')) {
                $table->dropForeign('warehouses_estate_id_foreign');
                $table->dropColumn('estate_id');
            }
            if (Schema::hasColumn('warehouses', 'city_id')) {
                $table->dropForeign('warehouses_city_id_foreign');
                $table->dropColumn('city_id');
            }
            if (!Schema::hasColumn('warehouses', 'parish_id')) {
                $table->integer('parish_id')->nullable()->comment('Parroquia está ubicado el almacen');
                $table->foreign('parish_id')->references('id')->on('parishes')
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
        Schema::table('warehouses', function (Blueprint $table) {
        });
    }
}
