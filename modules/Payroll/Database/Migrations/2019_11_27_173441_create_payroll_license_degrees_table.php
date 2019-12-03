<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollLicenseDegreesTable
 * @brief Crear tabla para los grados de licencia de conducir
 *
 * Gestiona la creación o eliminación de la tabla grados de licencia de conducir
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreatePayrollLicenseDegreesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_license_degrees')) {
            Schema::create('payroll_license_degrees', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 50)->comment('Nombre de la licencia de conducir');
                $table->string('description', 200)->comment('Descripción de la licencia de conducir');
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
        Schema::dropIfExists('payroll_license_degrees');
    }
}
