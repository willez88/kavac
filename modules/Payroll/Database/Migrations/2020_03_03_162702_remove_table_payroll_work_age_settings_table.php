<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class RemoveTablePayrollWorkAgeSettingsTable
 * @brief Elimina la tabla edad laboral de la base de datos
 *
 * Gestiona la eliminación de la tabla edad laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RemoveTablePayrollWorkAgeSettingsTable extends Migration
{
    /**
     * Método que elimina la tabla payroll_work_age_settings
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payroll_work_age_settings');
    }

    /**
     * Método que agrega la tabla payroll_work_age_settings
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_work_age_settings')) {
            Schema::create('payroll_work_age_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('age')->unsigned()->default(0)
                      ->comment('Edad laboral permitida para trabajar en una institución o empresa');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
