<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseInventaryRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventary_rules')) {    
            Schema::create('warehouse_inventary_rules', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('min')->comment('Cantidad minima que debe permitirse en un almacén');

                $table->integer('inventary_id')->comment('Identificador único del registro en la tabla de inventario de productos por almacen');
                $table->foreign('inventary_id')->references('id')->on('warehouse_inventary_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->comment('Identificador único del usuario que registra el cambio de regla');
                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                /*
                 * Fecha y hora en la que se registra el cambio de regla
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
        Schema::dropIfExists('warehouse_inventary_rules');
    }
}