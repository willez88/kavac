<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseMovementTable
 * @brief Crear tabla de Movimientos de Almacén
 * 
 * Gestiona la creación o eliminación de los movimientos de almacen realizados
 * Puden ser: recepciones (por compra u otro), transferencia entre almacenes, salientes (venta u otro)
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateWarehouseMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_movements')) {
           Schema::create('warehouse_movements', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('type')->nullable()->comment('Tipo de movimiento (0 => Compras,1 => Interno, 2 => Venta)');

                $table->string('observation')->nullable()->comment('Observaciones sobre la operación');
                $table->boolean('complete')->default(false)->comment('Indica si la operación fue realizada o completada correctamente');


                /*
                 * Intituciones y Almacenes involucrados
                 */
                $table->integer('warehouse_inst_start_id')->nullable()->comment('Identificador único de la relación (institución gestiona almacen) de donde parten los artículos');
                $table->foreign('warehouse_inst_start_id')->references('id')->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_inst_finish_id')->nullable()->comment('Identificador único de la relación (institución gestiona almacen) donde llegan los artículos');
                $table->foreign('warehouse_inst_finish_id')->references('id')->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->comment('Identificador único del usuario que registra el movimiento');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('warehouse_movements');
    }
}
