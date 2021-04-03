<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePayrollLangProfTable
 * @brief Crear tabla intermedia entre idioma y datos profesionales
 *
 * Gestiona la creación o eliminación de la tabla intermedia entre idioma y datos profesionales
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePayrollLangProfTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_lang_prof')) {
            Schema::create('payroll_lang_prof', function (Blueprint $table) {
                $table->id();

                $table->foreignId('payroll_lang_id')->comment('Identificador del idioma')
                      ->constrained('payroll_languages')->onUpdate('cascade')->onDelete('restrict');

                $table->foreignId('payroll_prof_id')->comment('Identificador del dato profesional')
                      ->constrained('payroll_professionals')->onUpdate('cascade')->onDelete('restrict');

                $table->foreignId('payroll_language_level_id')->comment('Identificador del nivel de idioma')
                      ->constrained()->onUpdate('cascade')->onDelete('restrict');

                $table->unique(
                    ['payroll_lang_id', 'payroll_prof_id'],
                )->comment('Clave única para el registro');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_lang_prof');
    }
}
