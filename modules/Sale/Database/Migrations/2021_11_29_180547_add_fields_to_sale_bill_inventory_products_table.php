<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToSaleBillInventoryProductsTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AddFieldsToSaleBillInventoryProductsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_bill_inventory_products', function (Blueprint $table) {
            $table->decimal('value', 20)->nullable()->comment('Precio unitario para los productos)');
            $table->string('product_type', 100)->nullable()->comment('Tipo de producto)');
            $table->foreignId('currency_id')->nullable()
                      ->comment('Forma de pago')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('history_tax_id')->nullable()
                      ->comment('IVA')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('measurement_unit_id')->nullable()
                      ->comment('Unidad de medida')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sale_goods_to_be_traded_id')->nullable()
                      ->comment('Servicio')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sale_list_subservices_id')->nullable()
                      ->comment('Subservicios')->constrained()
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
        Schema::table('sale_bill_inventory_products', function (Blueprint $table) {
            if (Schema::hasColumn('sale_bill_inventory_products', 'currency_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_currency_id_foreign')) {
                    $table->dropForeign('sale_bills_currency_id_foreign');
                }
                $table->dropColumn('currency_id');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'history_tax_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_history_tax_id_foreign')) {
                    $table->dropForeign('sale_bills_history_tax_id_foreign');
                }
                $table->dropColumn('history_tax_id');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'measurement_unit_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_measurement_unit_id_foreign')) {
                    $table->dropForeign('sale_bills_measurement_unit_id_foreign');
                }
                $table->dropColumn('measurement_unit_id');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'sale_goods_to_be_traded_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_goods_to_be_traded_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_goods_to_be_traded_id_foreign');
                }
                $table->dropColumn('sale_goods_to_be_traded_id');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'sale_list_subservices_id')) {
                if (has_foreign_key('sale_bills', 'sale_bills_sale_list_subservices_id_foreign')) {
                    $table->dropForeign('sale_bills_sale_list_subservices_id_foreign');
                }
                $table->dropColumn('sale_list_subservices_id');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'product_type')) {
                $table->dropColumn('product_type');
            };
            if (Schema::hasColumn('sale_bill_inventory_products', 'value')) {
                $table->dropColumn('value');
            };
        });
    }
}
