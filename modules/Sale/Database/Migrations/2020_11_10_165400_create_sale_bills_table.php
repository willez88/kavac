<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleBillsTable
 * @brief Crear tabla de facturas de comercialización
 *
 * Gestiona la creación o eliminación de la tabla de facturas del módulo de comercializción
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class CreateSaleBillsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Dcontreras <dcontreras@cenditel.gob.ve>
     * @return void
     */

    public function up()
    {
        Schema::create('sale_bills', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identificador único del registro');
            
            $table->string('state', 100)->nullable()->comment('Estado de la solicitud');
            $table->foreignId('sale_client_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('sale_warehouse_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('sale_payment_method_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('currency_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('sale_discount_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');                     

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_bills');
    }
}
