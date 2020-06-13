<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateWarehouseInventoryRulesTable
 * @brief Crear tabla de las reglas de abastecimiento de inventario de productos
 *
 * Gestiona la creación o eliminación de la tabla de reglas de abastecimiento de inventario de productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateWarehouseInventoryRulesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_inventory_rules')) {
            Schema::create('warehouse_inventory_rules', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->integer('minimum')->unsigned()->nullable()
                      ->comment('Cantidad mínima permitida de un producto en el almacén');
                $table->integer('maximum')->unsigned()->nullable()
                      ->comment('Cantidad máxima permitida de un producto en el almacén');

                $table->foreignId('warehouse_inventory_product_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('warehouse_inventory_rules');
    }
}
