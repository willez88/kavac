<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldGenderIdToPayrollStaffsTable
 * @brief Crear el campo gender_id a la información personal del trabajador
 *
 * Gestiona la creación o eliminación de un campo de la tabla información personal del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldGenderIdToPayrollStaffsTable extends Migration
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
            if (!Schema::hasColumn('payroll_staffs', 'payroll_gender_id')) {
                $table->bigInteger('payroll_gender_id')->unsigned()
                      ->comment('identificador de género que pertenece al personal');
                $table->foreign('payroll_gender_id')->references('id')->on('payroll_genders')
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
        Schema::table('payroll_staffs', function (Blueprint $table) {
            $table->dropColumn('payroll_gender_id');
        });
    }
}
