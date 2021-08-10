<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class ChangeFieldsSaleGoodsToBeTradeds
 * @brief Crear tabla de bienes a comercializar
 *
 * Gestiona la creación o eliminación de la tabla de bienes a comercializar
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ChangeFieldsSaleGoodsToBeTradeds extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sale_goods_to_be_tradeds');

        if (!Schema::hasTable('sale_goods_to_be_tradeds')) {
            Schema::create('sale_goods_to_be_tradeds', function (Blueprint $table) {
                $table->id();
                $table->string('name', 60)->nullable()->comment('Nombre');
                $table->text('description')->nullable()->comment('Descripción');
                $table->float('unit_price')->nullable()->comment('Precio Unitario');
                $table->foreignId('currency_id')->nullable()
                      ->comment('Moneda')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('measurement_unit_id')->nullable()
                      ->comment('Unidad de medida')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('department_id')->nullable()
                      ->comment('Unidades y dependencias a cargo')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('history_tax_id')->nullable()
                      ->comment('IVA')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->foreignId('sale_type_good_id')->nullable()
                      ->comment('Tipo de bien')->constrained()
                      ->onUpdate('cascade')->onDelete('restrict');
                $table->boolean('define_attributes')->default(false)
                          ->comment('Establecer atributos personalizados. (true) si, (false) no');

                if (!Schema::hasTable('payroll_staffs')) {
                    // Si payroll no esta instalado
                    $table->string('name_worker', 100)->comment('Nombre');
                    $table->string('last_name_worker', 500)->comment('Apellido');
                    $table->string('phone_worker', 500)->comment('Teléfono');
                    $table->string('email_worker', 500)->comment('Correo electrónico');
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
        Schema::dropIfExists('sale_goods_to_be_tradeds');
    }
}
