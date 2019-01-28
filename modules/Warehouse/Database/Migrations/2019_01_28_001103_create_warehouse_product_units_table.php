<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseProductUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_product_units')) {    
            Schema::create('warehouse_product_units', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name',20)->comment('Nombre o Abreviatura de la unidad métrica');
                $table->string('description',100)->nullable()->comment('Descripción breve de la unidad');
                /**
                 * Fecha en la que se registra la unidad métrica
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_product_units');
    }
}
