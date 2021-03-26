<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToSaleClients
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UpdateFieldsToSaleClients extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_clients', function (Blueprint $table) {
            $table->string('rif', 100)->nullable()->comment('Rif')->change();
            $table->string('name_client', 100)->comment('Name of client')->nullable()->change();
            if (Schema::hasTable('sale_clients')) {
                if (Schema::hasColumn('sale_clients', 'city_id')) {
                    $table->dropForeign(['city_id']);
                    $table->dropColumn('city_id');
                };
                if (Schema::hasColumn('sale_clients', 'address')) {
                    $table->dropColumn('address');
                };
                if (Schema::hasColumn('sale_clients', 'email_client')) {
                    $table->dropColumn('email_client');
                };
                if (Schema::hasColumn('sale_clients', 'phone_client')) {
                    $table->dropColumn('phone_client');
                };  
                if (!Schema::hasColumn('business_name', 'representative_name', 'emails', 'phones', 'id_number', 'id_type')) {
                    $table->string('business_name', 100)->nullable()->comment('Razón social');
                    $table->string('representative_name', 100)->nullable()->comment('Nombres y apellidos del representante legal');
                    $table->string('emails')->nullable()->comment('Correos electrónicos del cliente');
                    $table->string('phones')->nullable()->comment('Números telefónicos del cliente');
                    $table->string('id_number', 10)->nullable()->comment('Número de identificación (cédula, pasaporte)');
                    $table->string('id_type', 2)->nullable()->comment('Tipo de identificación');
                }
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
        Schema::table('sale_clients', function (Blueprint $table) {
            $table->string('rif', 100)->comment('Rif')->change();
            $table->string('name_client', 100)->comment('Name of client')->change();
            if (Schema::hasTable('sale_clients')) {
                if (Schema::hasColumn('sale_clients', 'business_name')) {
                    $table->dropColumn('business_name');
                };
                if (Schema::hasColumn('sale_clients', 'representative_name')) {
                    $table->dropColumn('representative_name');
                };
                if (Schema::hasColumn('sale_clients', 'emails')) {
                    $table->dropColumn('emails');
                };
                if (Schema::hasColumn('sale_clients', 'phones')) {
                    $table->dropColumn('phones');
                };
                if (Schema::hasColumn('sale_clients', 'id_number')) {
                    $table->dropColumn('id_number');
                };
                if (Schema::hasColumn('sale_clients', 'id_type')) {
                    $table->dropColumn('id_type');
                };
                if (!Schema::hasColumn('city_id', 'address', 'email_client', 'phone_client')) {
                    $table->foreignId('city_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                    $table->string('address', 200)->comment('location of client');
                    $table->string('email_client')->unique()->nullable()->comment('Email of client');
                    $table->string('phone_client', 100)->comment('Name of client');
                };
            }
        });
    }
}
