<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollLanguagesTable
 * @brief Crear tabla de idiomas
 *
 * Gestiona la creación o eliminación de la tabla de idiomas
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreatePayrollLanguagesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_languages')) {
            Schema::create('payroll_languages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 100)->comment('Nombre del idioma');
                $table->string('acronym', 10)->comment('Acrónimo del idioma');
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
        Schema::dropIfExists('payroll_languages');
    }
}
