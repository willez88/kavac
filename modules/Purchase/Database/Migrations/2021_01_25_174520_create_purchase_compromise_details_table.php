<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreatePurchaseCompromiseDetailsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreatePurchaseCompromiseDetailsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_compromise_details')) {
            Schema::create('purchase_compromise_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('description');
                $table->float('amount', 30, 10)->comment('Monto comprometido a la cuenta presupuestaria');
                $table->float('tax_amount', 30, 10)->default(0)
                      ->comment('Monto del impuesto aplicado al comprometido de la cuenta presupuestaria');
                $table->foreignId('tax_id')->constrained()->onUpdate('cascade');
                $table->foreignId('purchase_compromise_id')->constrained()->onUpdate('cascade');
                $table->foreignId('budget_account_id')->nullable()->constrained()->onUpdate('cascade');
                $table->unsignedBigInteger('budget_sub_specific_formulation_id')->nullable()->comment(
                    'Identificador asociado a la Formulación'
                );
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
            
            Schema::table('purchase_compromise_details', function (Blueprint $table) {
                if (!has_foreign_key('purchase_compromise_details', 'budget_compromise_details_formulation_fk')) {
                    $table->foreign(
                        'budget_sub_specific_formulation_id',
                        'budget_compromise_details_formulation_fk'
                    )->references('id')->on('budget_sub_specific_formulations')->onUpdate('cascade');
                }
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
        Schema::dropIfExists('purchase_compromise_details');
    }
}
