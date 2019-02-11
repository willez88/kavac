<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseInventaryProductMovementTable
 * @brief Crear tabla de Movimientos de Almacén por producto
 * 
 * Gestiona las cantidades de los productos movilizados entre almacenes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateWarehouseInventaryProductMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventary_product_movements')) {
            Schema::create('warehouse_inventary_product_movements', function (Blueprint $table) {
                
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('quantity')->comment('Cantidad del producto Movilizada');
                $table->float('new_value')->comment('Nuevo precio del producto movilizado');
                $table->string('reference')->nullable()->comment('Numero de referencia del producto movilizado');
                
                
                $table->integer('movement_id')->comment('Identificador único del movimiento de almacén realizado');
                $table->foreign('movement_id')->references('id')->on('warehouse_movements')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('inventary_product_id')->comment('Identificador único del producto en el inventario');
                $table->foreign('inventary_product_id')->references('id')->on('warehouse_inventary_products')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('warehouse_inventary_product_movements');
    }
}
