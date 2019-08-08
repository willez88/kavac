<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldNationalityIdToPayrollStaffsTable
 * @brief Crear el campo nationality_id a la información personal del trabajador
 *
 * Gestiona la creación o eliminación de un campo de la tabla nacionalidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AddFieldNationalityIdToPayrollStaffsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_staffs', function (Blueprint $table) {
            $table->integer('payroll_nationality_id')->unsigned()->nullable()
                  ->comment('identificador de nacionalidad que pertenece al personal');
            $table->foreign('payroll_nationality_id')->references('id')->on('payroll_nationalities')
                  ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('payroll_staffs', function (Blueprint $table) {
            $table->dropForeign('payroll_staffs_payroll_nationality_id_foreign');
            $table->dropColumn('payroll_nationality_id');
        });
    }
}
