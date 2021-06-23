<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateSaleGoodsToBeTradeds
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateSaleGoodsToBeTradeds extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_goods_to_be_tradeds', function (Blueprint $table) {
            if (Schema::hasColumn('sale_goods_to_be_tradeds', 'coin')) {
                //Se elimina Coin por currency_id
                $table->dropColumn(['coin']); 
            };    
            if (Schema::hasColumn('sale_goods_to_be_tradeds', 'iva')) {
                //Se elimina IVA por taxes
                $table->dropColumn(['iva']);
                if (Schema::hasTable('taxes')) {
                    $table->after('custom_attribute', function ($table) {
                        $table->integer('taxes_id')->unsigned()->nullable()->comment('Impuesto al Valor Agregado (IVA)');
                    });
                }
            };
            if (Schema::hasTable('sale_goods_to_be_tradeds')) {
                $table->after('custom_attribute', function ($table) {
                    $table->integer('currency_id')->unsigned()->nullable()->comment('Unidad monetaria.');
                    $table->integer('unit_of_measurement_id')->unsigned()->nullable()->comment('Unidad de Medida');
                    $table->integer('units_depend_charge_id')->unsigned()->nullable()->comment('Unidades y dependencias a cargo');
                });
                if (!Schema::hasTable('payroll_staff_types')) {
                    //SI TH NO ESTA INSTALADO
                    $table->after('custom_attribute', function ($table) {
                        $table->string('name_worker', 100)->comment('Nombre');
                        $table->string('Surname_worker', 500)->comment('Apellido');
                        $table->string('Telephone_worker', 500)->comment('Teléfono');
                        $table->string('Email_worker', 500)->comment('Correo electrónico');
                    });
                }
                else{
                    //SI TH ESTA INSTALADO
                    //Lista de trabajadores relacionada por id
                    $table->after('custom_attribute', function ($table) {
                        $table->integer('worker_id')->unsigned()->nullable()->comment('lista de trabajadores');
                    });
                }
            }; 
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_goods_to_be_tradeds', function (Blueprint $table) {
            if (Schema::hasTable('sale_goods_to_be_tradeds')) {
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'currency_id')) {
                //Se elimina Coin por currency_id
                $table->dropColumn(['currency_id']);
                };    
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'taxes_id')) {
                //Se elimina Coin por taxes_id
                $table->dropColumn(['taxes_id']);
                };    
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'unit_of_measurement_id')) {
                //Se elimina Coin por unit_of_measurement_id
                $table->dropColumn(['unit_of_measurement_id']);
                };    
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'units_depend_charge_id')) {
                //Se elimina Coin por units_depend_charge_id
                $table->dropColumn(['units_depend_charge_id']);
                };    
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'worker_id')) {
                //Se elimina Coin por worker_id
                $table->dropColumn(['worker_id']);
                };        
                
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'name_worker')) {
                //Se elimina Coin por name_worker
                $table->dropColumn(['name_worker']);
                };      
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'Surname_worker')) {
                //Se elimina Coin por Surname_worker
                $table->dropColumn(['Surname_worker']);
                };      
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'Telephone_worker')) {
                //Se elimina Coin por Telephone_worker
                $table->dropColumn(['Telephone_worker']);
                };      
                if (Schema::hasColumn('sale_goods_to_be_tradeds', 'Email_worker')) {
                //Se elimina Coin por Email_worker
                $table->dropColumn(['Email_worker']);
                };                                                                                             
            }

        });
    }
}
