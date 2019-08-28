<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehousesTable
 * @brief Crear tabla de almacenes
 *
 * Gestiona la creación o eliminación de la tabla de almacenes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouses')) {
            Schema::create('warehouses', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name')->comment('Nombre o descripción del almacen');
                
                $table->boolean('main')->default(false)
                      ->comment('Define si es el almacen principal.');
                
                $table->string('address')->comment('Dirección física del almacen');
                
                $table->integer('country_id')->comment('Pais donde está ubicado el almacen');
                $table->foreign('country_id')->references('id')->on('countries')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('estate_id')->comment('Estado donde está ubicado el almacen');
                $table->foreign('estate_id')->references('id')->on('estates')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('city_id')->comment('Ciudad donde está ubicado el almacen');
                $table->foreign('city_id')->references('id')->on('cities')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();

                /*
                 * Fecha y hora en la que fue elimidado el registro
                 */
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
        Schema::dropIfExists('warehouses');
    }
}
