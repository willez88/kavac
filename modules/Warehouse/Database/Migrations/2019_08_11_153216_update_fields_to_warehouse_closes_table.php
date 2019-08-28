<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseClosesTable
 * @brief Actualiza los campos de la tabla de cierres de almacén
 *
 * Gestiona la actualización de los campos de la tabla de cierres de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseClosesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_closes', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_closes', 'date_init')) {
                $table->renameColumn('date_init', 'initial_date');
            }

            if (Schema::hasColumn('warehouse_closes', 'date_end')) {
                $table->renameColumn('date_end', 'end_date');
            }

            if (Schema::hasColumn('warehouse_closes', 'user_init')) {
                $table->dropForeign('warehouse_closes_user_init_foreign');
                $table->renameColumn('user_init', 'initial_user_id');
                $table->foreign('initial_user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');
            }

            if (Schema::hasColumn('warehouse_closes', 'user_end')) {
                $table->dropForeign('warehouse_closes_user_end_foreign');
                $table->renameColumn('user_end', 'end_user_id');
                $table->foreign('end_user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');
            }

            if (Schema::hasColumn('warehouse_closes', 'observation')) {
                $table->renameColumn('observation', 'observations');
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
        Schema::table('warehouse_closes', function (Blueprint $table) {
        });
    }
}
