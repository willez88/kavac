<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToSaleBillsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToSaleBillsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            if (Schema::hasColumn('sale_bills', 'sale_client_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_client_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_client_id_foreign');
                }
                $table->dropColumn('sale_client_id');
            };
            if (Schema::hasColumn('sale_bills', 'sale_warehouse_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_warehouse_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_warehouse_id_foreign');
                }
                $table->dropColumn('sale_warehouse_id');
            };
            if (Schema::hasColumn('sale_bills', 'sale_payment_method_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_payment_method_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_payment_method_id_foreign');
                }
                $table->dropColumn('sale_payment_method_id');
            };
            if (Schema::hasColumn('sale_bills', 'currency_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_currency_id_foreign')) {
                    $table->dropForeign('sale_bills_currency_id_foreign');
                }
                $table->dropColumn('currency_id');
            };
            if (Schema::hasColumn('sale_bills', 'sale_discount_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_discount_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_discount_id_foreign');
                }
                $table->dropColumn('sale_discount_id');
            };

            $table->string('type', 100)->nullable()->comment('Tipo de factura)');
            $table->string('type_person', 100)->nullable()->comment('Tipo de persona (Jurídica o Natural)');
            $table->string('name', 300)->nullable()->comment('Nombre del solicitante');
            $table->string('id_number', 10)->nullable()->comment('Cédula (Natural)');
            $table->string('rif', 10)->nullable()->comment('RIF (Jurídica)');
            $table->string('phone', 100)->nullable()->comment('Telefono del solicitante');
            $table->string('email', 100)->nullable()->comment('Correo del solicitante');
            $table->foreignId('sale_form_payment_id')->nullable()
                      ->comment('Forma de pago')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
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
            if (!Schema::hasColumn('sale_bills', 'sale_client_id')) {
                $table->foreignId('sale_client_id')->nullable()
                      ->comment('Cliente')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            };
            if (!Schema::hasColumn('sale_bills', 'sale_warehouse_id')) {
                $table->foreignId('sale_warehouse_id')->nullable()
                      ->comment('Almacén')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            };
            if (!Schema::hasColumn('sale_bills', 'sale_payment_method_id')) {
                $table->foreignId('sale_payment_method_id')->nullable()
                      ->comment('Forma de pago')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            };
            if (!Schema::hasColumn('sale_bills', 'currency_id')) {
                $table->foreignId('currency_id')->nullable()
                      ->comment('Forma de pago')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            };
            if (!Schema::hasColumn('sale_bills', 'sale_discount_id')) {
                $table->foreignId('sale_discount_id')->nullable()
                      ->comment('Descuentos')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            };
            if (Schema::hasColumn('sale_bills', 'sale_form_payment_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_form_payment_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_form_payment_id_foreign');
                }
                $table->dropColumn('sale_form_payment_id');
            };
            if (!Schema::hasColumn('sale_bills', 'type_person')) {
                $table->dropColumn('type_person');
            };
            if (!Schema::hasColumn('sale_bills', 'name')) {
                $table->dropColumn('name');
            };
            if (!Schema::hasColumn('sale_bills', 'id_number')) {
                $table->dropColumn('id_number');
            };
            if (!Schema::hasColumn('sale_bills', 'rif')) {
                $table->dropColumn('rif');
            };
            if (!Schema::hasColumn('sale_bills', 'phone')) {
                $table->dropColumn('phone');
            };
            if (!Schema::hasColumn('sale_bills', 'email')) {
                $table->dropColumn('email');
            };
        });
    }
}
