<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldRejectedReasonToSaleBillsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldRejectedReasonToSaleBillsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_bills', 'rejected_reason')) {
                $table->text('rejected_reason')->nullable()->comment('Motivo de rechazo de la factura');
            }
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
           if (Schema::hasColumn('sale_bills', 'rejected_reason')) {
                $table->dropColumn('rejected_reason');
            } 
        });
    }
}
