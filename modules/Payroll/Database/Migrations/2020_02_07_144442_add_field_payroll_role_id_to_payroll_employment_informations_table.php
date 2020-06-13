<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldPayrollRoleIdToPayrollEmploymentInformationsTable
 * @brief Crear campos payroll_role_id a la información laboral del trabajador
 *
 * Gestiona la creación o eliminación de un campo de la tabla información laboral del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldPayrollRoleIdToPayrollEmploymentInformationsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_employment_informations', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_employment_informations', 'payroll_role_id')) {
                $table->foreignId('payroll_role_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_employment_informations', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_employment_informations', 'payroll_role_id')) {
                $table->dropColumn('payroll_role_id');
            }
        });
    }
}
