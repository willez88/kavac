<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseClosesTable
 * @brief Crear tabla de cierres de almacén
 *
 * Gestiona la creación o eliminación de la tabla de cierres de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseClosesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_closes')) {
            Schema::create('warehouse_closes', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->date('date_init')->comment('Fecha y hora en que inicia el cierre de almacen');
                $table->date('date_end')->nullable()->comment('Fecha y hora en que termina el cierre de almacen');

                $table->integer('user_init')
                      ->comment('Identificador único del usuario que termina el cierre de almacen');
                $table->foreign('user_init')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_end')->nullable()
                      ->comment('Identificador único del usuario que termina el cierre de almacen');
                $table->foreign('user_end')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('warehouse_id')->comment('Identificador único del almacen que cierra sus funciones');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('observation')->nullable()->comment('Observación referente al cierre de almacen');

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
        Schema::dropIfExists('warehouse_closes');
    }
}
