<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseProductUnitsTable
 * @brief Crear tabla de unidades de medida de los productos
 *
 * Gestiona la creación o eliminación de la tabla de unidades de medida
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseProductUnitsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_product_units')) {
            Schema::create('warehouse_product_units', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->string('name', 20)->comment('Nombre o descripción de la unidad métrica');
                
                /**
                 * Fecha en la que se registra la unidad métrica
                 */
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
        Schema::dropIfExists('warehouse_product_units');
    }
}
