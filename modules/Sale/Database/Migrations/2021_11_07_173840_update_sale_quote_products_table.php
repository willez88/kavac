<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateSaleQuoteProductsTable
 * @brief Modifica la tabla sale_quote_products para nuevas funcionalidades
 *
 * Modifica la tabla sale_quote_products para nuevas funcionalidades
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateSaleQuoteProductsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_quote_products', function (Blueprint $table) {
            //remove previous fields
            $fields = [
                    'name_enterprise',
                    'address_applicant',
                    'name_applicant',
                    'phone_applicant',
                    'description_product',
                    'quantity_product',
                    'unit_product',
                    'payment_type_product',
                    'reply_deadline_product',
            ];
            foreach ($fields as $field) {
                if (Schema::hasColumn('sale_quote_products', $field)) {
                    $table->dropColumn([$field]);
                }
            }

            if (Schema::hasColumn('sale_quote_products', 'sale_payment_method_id')) {
                if (has_foreign_key('sale_quote_products', 'sale_quotes_sale_payment_method_id_foreign')) {
                    $table->dropForeign('sale_quotes_sale_payment_method_id_foreign');
                }
                $table->dropColumn(['sale_payment_method_id']);
            }

            $table
                ->decimal('value', 13, 2)
                ->nullable()
                ->comment('Valor del producto');

            $table
              ->string('product_type', 200)
              ->comment('Tipo de Producto');

            $table->foreignId('sale_quote_id')
              ->nullable()
              ->comment('Cotizacion a la que pertenece el producto')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table
                ->foreignId('currency_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->comment('Id de la moneda (currency)');

            $table->foreignId('measurement_unit_id')
              ->nullable()
              ->comment('Unidades de medida')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table
                ->integer('quantity')
                ->unsigned()
                ->nullable()
                ->comment('Cantidad del productos');

            $table
                ->decimal('total', 13, 2)
                ->nullable()
                ->comment('Valor total');

            $table
                ->decimal('total_without_tax', 13, 2)
                ->nullable()
                ->comment('Valor total sin impuesto');

            $table->foreignId('sale_warehouse_inventory_product_id')
              ->nullable()
              ->comment('Producto en el inventario del almacen')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table
              ->foreignId('sale_type_good_id')
              ->nullable()
              ->comment('Producto para ser comercializado')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');


            $table->foreignId('history_tax_id')
              ->nullable()
              ->comment('IVA')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreignId('sale_list_subservices_id')
              ->nullable()
              ->comment('Subservice')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('restrict');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_quote_products', function (Blueprint $table) {

            //remove foreigns id
            $foreigns = [
                    'sale_quote_id',
                    'currency_id',
                    'measurement_unit_id',
                    'sale_type_good_id',
                    'sale_warehouse_inventory_product_id',
                    'history_tax_id',
                    'sale_list_subservices_id',
            ];
            foreach ($foreigns as $field) {

                if (!Schema::hasColumn('sale_quote_products', $field)) {
                    $foreign_id = 'sale_quote_products_' . $field . '_foreign';
                    if (has_foreign_key('sale_quote_products', $foreign_id)) {
                        $table->dropForeign($foreign_id);
                    }
                    $table->dropColumn([$field]);
                }
            }

            //remove fields
            $fields = [
                    'product_type',
                    'value',
                    'quantity',
                    'total',
                    'total_without_tax',
            ];
            foreach ($fields as $field) {
                if (Schema::hasColumn('sale_quote_products', $field)) {
                    $table->dropColumn([$field]);
                }
            }

            //create previous fields
            $table->string('name_enterprise', 200)->nullable()->comment('Name de la empresa');
            $table->string('address_applicant', 200)->comment('Dirección del solicitante');
            $table->string('name_applicant', 100)->comment('Nombre del solicitante');
            $table->string('email_applicant')->unique()->nullable()->comment('Correo del solicitante');
            $table->string('phone_applicant')->nullable()->comment('Telefono del solicitante');
            $table->string('description_product')->nullable()->comment('Descripcion del producto');
            $table->string('quantity_product')->nullable()->comment('Cantidad del producto');
            $table->string('unit_product')->nullable()->comment('Unidad de medida');
            $table->string('payment_type_product')->nullable()->comment('Tipo de producto');
            $table->string('reply_deadline_product')->nullable()->comment('Fecha límite de respuesta');
        });
    }
}
