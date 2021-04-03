<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class DropPayrollLanguageLanguageLevelProfessionalTable
 * @brief Eliminar tabla
 *
 * Gestiona la creación o eliminación de la tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DropPayrollLanguageLanguageLevelProfessionalTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payroll_language_language_level_professional');
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_language_language_level_professional')) {
            Schema::create('payroll_language_language_level_professional', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('payroll_language_id');
                $table->foreign(
                    'payroll_language_id',
                    'payroll_language_language_level_professional_language_fk'
                )->references('id')->on('payroll_languages')->onDelete('cascade');

                $table->unsignedBigInteger('payroll_language_level_id');
                $table->foreign(
                    'payroll_language_level_id',
                    'payroll_language_language_level_professional_level_fk'
                )->references('id')->on('payroll_language_levels')->onDelete('cascade');

                $table->unsignedBigInteger('payroll_professional_id')->nullable();
                $table->foreign(
                    'payroll_professional_id',
                    'payroll_language_language_level_professional_professional_fk'
                )->references('id')->on('payroll_professionals')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
