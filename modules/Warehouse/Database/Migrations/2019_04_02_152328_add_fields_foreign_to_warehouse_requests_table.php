<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsForeignToWarehouseRequestsTable
 * @brief Agregar las llaves foráneas de la tabla de solicitudes de almacén
 *
 * Gestiona la agregación de llaves foráneas de la tabla de solicitudes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsForeignToWarehouseRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_requests', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_requests', 'project_id')) {
                $table->dropColumn('project_id');
            }
            if (Schema::hasColumn('warehouse_requests', 'centralized_action_id')) {
                $table->dropColumn('centralized_action_id');
            }
            
            if (!Schema::hasColumn('warehouse_requests', 'motive')) {
                $table->string('motive')->comment('Motivo de la solicitud');
            }
            if (Schema::hasColumn('warehouse_requests', 'specific_action_id')) {
                $table->foreign('specific_action_id')->references('id')->on('budget_specific_actions')
                      ->onDelete('restrict')->onUpdate('cascade');
            }
            if (Schema::hasColumn('warehouse_requests', 'dependence_id')) {
                $table->foreign('dependence_id')->references('id')->on('departments')
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
        Schema::table('warehouse_requests', function (Blueprint $table) {
        });
    }
}
