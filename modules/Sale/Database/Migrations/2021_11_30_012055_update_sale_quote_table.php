<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateSaleQuoteTable
 * @brief Cambia el campo payment method a form payments
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateSaleQuoteTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_quotes', function (Blueprint $table) {

            if (Schema::hasColumn('sale_quotes', 'sale_payment_method_id')) {
                if (has_foreign_key('sale_quotes', 'sale_quotes_sale_payment_method_id_foreign')) {
                    $table->dropForeign('sale_quotes_sale_payment_method_id_foreign');
                }
                $table->dropColumn(['sale_payment_method_id']);
            }
            $table->foreignId('sale_form_payment_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_quotes', function (Blueprint $table) {
            //remove foreigns id
            $foreigns = [
                    'sale_form_payment_id',
            ];
            foreach ($foreigns as $field) {

                if (!Schema::hasColumn('sale_quotes', $field)) {
                    $foreign_id = 'sale_quotes_' . $field . '_foreign';
                    if (has_foreign_key('sale_quotes', $foreign_id)) {
                        $table->dropForeign($foreign_id);
                    }
                    $table->dropColumn([$field]);
                }
            }
            $table->foreignId('sale_payment_method_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
        });
    }
}
