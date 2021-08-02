<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeFieldToPayrollLanguageLanguageLevelProfessionalTable
 * @brief Altera campos en la tabla payroll_language_language_level_professional
 *
 * Gestiona cambios en la tabla payroll_language_language_level_professional
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ChangeFieldToPayrollLanguageLanguageLevelProfessionalTable extends Migration
{
    /**
     * Método que elimina la tabla debido a que ya no está en uso
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payroll_language_language_level_professional');
    }

    /**
     * Método que elimina la tabla debido a que ya no está en uso
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_language_language_level_professional');
    }
}
