<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldToPayrollChildrensTable
 * @brief agrega el campo payroll_socioeconomic_id a la tabla
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldToPayrollChildrensTable extends Migration
{
    /**
     * Método que agrega el campo payroll_socioeconomic_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_childrens', 'payroll_socioeconomic_id')) {
                $table->bigInteger('payroll_socioeconomic_id')->unsigned()->nullable()
                      ->comment('identificador de socioeconómico que pertenecen al hijo');
                $table->foreign('payroll_socioeconomic_id')->references('id')
                      ->on('payroll_socioeconomics')->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que elimina el campo payroll_socioeconomic_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_childrens', 'payroll_socioeconomic_id')) {
                $table->dropColumn('payroll_socioeconomic_id');
            }
        });
    }
}
