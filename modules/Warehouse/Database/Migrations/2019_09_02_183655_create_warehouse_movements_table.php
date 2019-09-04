<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseMovementsTable
 * @brief Crear tabla de movimientos de almacén
 *
 * Gestiona la creación o eliminación de la tabla de movimientos de almacen registrados
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_movements')) {
            Schema::create('warehouse_movements', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del movimiento');

                $table->enum('type', ['C', 'M', 'V'])
                      ->comment('Tipo de movimiento: (C)ompra, (M)ovimiento interno o (V)enta');

                $table->text('description')->nullable()
                      ->comment('Descripción del movimiento de almacén');
                $table->text('observations')->nullable()->comment('Observaciones sobre la operación');
                $table->string('state', 100)->nullable()->comment('Estado de la operación');

                $table->integer('warehouse_institution_warehouse_initial_id')->unsigned()->nullable()
                  ->comment('Identificador único de la ubicación inicial del producto en la tabla institución-almacén');
                $table->foreign('warehouse_institution_warehouse_initial_id')->references('id')
                      ->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_institution_warehouse_end_id')->unsigned()->nullable()
                  ->comment('Identificador único de la ubicación final del producto en la tabla institución-almacén)');
                $table->foreign('warehouse_institution_warehouse_end_id')->references('id')
                      ->on('warehouse_institution_warehouses')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->unsigned()
                      ->comment('Identificador único del usuario que registra el movimiento');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_movements');
    }
}
