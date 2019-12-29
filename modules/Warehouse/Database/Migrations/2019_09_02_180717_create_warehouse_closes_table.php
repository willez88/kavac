<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseClosesTable
 * @brief Crear tabla de los cierres de almacén
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
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->date('initial_date')->comment('Fecha y hora en que inicia el cierre de almacén');
                $table->date('end_date')->nullable()->comment('Fecha y hora en que termina el cierre de almacén');

                $table->bigInteger('initial_user_id')
                      ->comment('Identificador único del usuario que inicia el cierre de almacén');
                $table->foreign('initial_user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('end_user_id')->nullable()
                      ->comment('Identificador único del usuario que termina el cierre de almacén');
                $table->foreign('end_user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('warehouse_id')->comment('Identificador único del almacén que cierra sus funciones');
                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->text('observations')->nullable()->comment('Observación asociada al cierre de almacén');

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
