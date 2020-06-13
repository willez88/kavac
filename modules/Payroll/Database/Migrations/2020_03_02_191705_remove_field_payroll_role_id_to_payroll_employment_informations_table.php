<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveFieldPayrollRoleIdToPayrollEmploymentInformationsTable
 * @brief Elimina el campo rol de la tabla de informaciones laborales del trabajador
 *
 * Gestiona la eliminación de un campo en la tabla de informaciones laborales del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RemoveFieldPayrollRoleIdToPayrollEmploymentInformationsTable extends Migration
{
    /**
     * Método que elimina el campo payroll_role_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_employment_informations', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_employment_informations', 'payroll_role_id')) {
                $table->dropForeign('payroll_employment_informations_payroll_role_id_foreign');
                $table->dropColumn('payroll_role_id');
            }
        });
    }

    /**
     * Método que agrega el campo payroll_role_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_employment_informations', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_employment_informations', 'payroll_role_id')) {
                $table->foreignId('payroll_role_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
