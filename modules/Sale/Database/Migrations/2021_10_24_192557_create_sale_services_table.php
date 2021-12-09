<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleServicesTable
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CreateSaleServicesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_services')) {
            Schema::create('sale_services', function (Blueprint $table) {
                $table->id();

                $table->string('code', 100)->nullable()->comment('Código de la solicitud de servicios');
                $table->string('name', 100)->nullable()->comment('Nombre del solicitante');
                $table->string('organization', 200)->nullable()->comment('Organización del solicitante');
                $table->text('description')->nullable()->comment('Descripción de la actividad económica');
                $table->text('resume')->nullable()->comment('Resumen de la solicitud');
                $table->string('status', 20)->nullable()->comment('Estatus de la solicitud');
                $table->text('sale_goods_to_be_traded')->nullable()->comment('Bienes a comercializar');
                $table->foreignId('sale_client_id')->nullable()
                      ->comment('Cliente')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');

                if (!Schema::hasTable('payroll_staffs')) {
                    // Si payroll no esta instalado
                    $table->string('name_worker', 100)->comment('Nombre');
                    $table->string('last_name_worker', 100)->comment('Apellido');
                    $table->string('email_worker', 200)->comment('Correo electrónico');
                }
                else{
                    $table->foreignId('payroll_staff_id')->nullable()
                      ->comment('Lista de trabajadores')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                }

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('sale_services');
    }
}
