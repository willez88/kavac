<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollWorkAgeSettingsTable
 * @brief Crear tabla para la edad laboral permitida
 *
 * Gestiona la creación o eliminación de la tabla para la edad laboral permitida
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollWorkAgeSettingsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
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

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_work_age_settings');
    }
}
