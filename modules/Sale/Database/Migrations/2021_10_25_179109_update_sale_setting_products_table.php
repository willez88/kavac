<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateSaleSettingProductsTable
 * @brief [descripción detallada]
 *
 * Elimina los campos code, price, produc type e iva
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateSaleSettingProductsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_setting_products', function (Blueprint $table) {
            if (Schema::hasColumn('sale_setting_products', 'sale_setting_product_type_id')) {
                if (has_foreign_key('sale_setting_products', 'sale_setting_products_sale_setting_product_type_id_foreign')) {
                    $table->dropForeign('sale_setting_products_sale_setting_product_type_id_foreign');
                }
                $table->dropColumn(['sale_setting_product_type_id']);
            }
            foreach (['code', 'price', 'iva'] as $field) {
                if (Schema::hasColumn('sale_setting_products', $field)) {
                    $table->dropColumn([$field]);
                }
            }
            $table
                ->boolean('attributes')
                ->default(false)
                ->comment('Establecer atributos personalizados. (true) si, (false) no');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_setting_products', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_setting_products', 'sale_setting_product_type_id')) {
                $table->foreignId('sale_setting_product_type_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('sale_setting_products', 'code')) {
                $table->string('code')->comment('Código');
            }
            if (!Schema::hasColumn('sale_setting_products', 'price')) {
                $table->string('price')->comment('Precio unitario');
            }
            if (!Schema::hasColumn('sale_setting_products', 'iva')) {
                $table->string('iva')->nullable()
                    ->comment('IVA');
            }
            if (!Schema::hasColumn('sale_setting_products', 'attributes')) {
                $table->dropColumn(['attributes']);
            }
        });
    }
}
