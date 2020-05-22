<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveFieldToPayrollChildrensTable
 * @brief remueve el campo payroll_socioeconomic_information_id de la tabla
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RemoveFieldToPayrollChildrensTable extends Migration
{
    /**
     * Método que elimina el campo payroll_socioeconomic_information_id de la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_childrens', 'payroll_socioeconomic_information_id')) {
                $table->dropColumn('payroll_socioeconomic_information_id');
            }
        });
    }

    /**
     * Método que agrega el campo payroll_socioeconomic_information_id a la tabla
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_childrens', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_childrens', 'payroll_socioeconomic_information_id')) {
                $table->bigInteger('payroll_socioeconomic_information_id')->unsigned()->nullable()
                      ->comment('identificador de información socioeconómica que pertenecen al hijo');
                $table->foreign('payroll_socioeconomic_information_id')->references('id')
                      ->on('payroll_socioeconomic_informations')->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }
}
