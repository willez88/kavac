<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveFieldToPayrollOrganizationsTable
 * @brief remueve el campo payroll_employment_information_id de la tabla
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RemoveFieldToPayrollOrganizationsTable extends Migration
{
    /**
     * Método que elimina el campo payroll_employment_information_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_organizations', function (Blueprint $table) {
            $foreignKeys = list_table_foreign_keys('payroll_organizations');
            if (in_array('payroll_organizations_payroll_employment_information_id_foreign', $foreignKeys)) {
                $table->dropForeign('payroll_organizations_payroll_employment_information_id_foreign');
            }
            if (Schema::hasColumn('payroll_organizations', 'payroll_employment_information_id')) {
                $table->dropColumn('payroll_employment_information_id');
            }
        });
    }

    /**
     * Método que agrega el campo payroll_employment_information_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_organizations', 'payroll_employment_information_id')) {
                $table->foreignId('payroll_employment_information_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
