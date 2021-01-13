<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class      AddFieldInstitutionIdToPayrollVacationRequestsTable
 * @brief      Agrega el campo institución a la tabla de solicitudes de vacaciones
 *
 * Gestiona la creación o eliminación del campo institución a la tabla de solicitudes de vacaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldInstitutionIdToPayrollVacationRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function up()
    {
        if (Schema::hasTable('payroll_vacation_requests')) {
            Schema::table('payroll_vacation_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('payroll_vacation_requests', 'institution_id')) {
                    $table->foreignId('institution_id')->nullable()
                          ->comment('Identificador único asociado a la institución')
                          ->constrained()->onDelete('restrict')->onUpdate('cascade');
                };
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    void
     */
    public function down()
    {
        if (Schema::hasTable('payroll_vacation_requests')) {
            Schema::table('payroll_vacation_requests', function (Blueprint $table) {
                if (Schema::hasColumn('payroll_vacation_requests', 'institution_id')) {
                    $table->dropForeign(['institution_id']);
                    $table->dropColumn('institution_id');
                };
            });
        };
    }
}
