<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class UpdateFieldsToWarehouseInventoryRulesTable
 * @brief Actualiza los campos de la tabla de reglas de abastecimiento de los productos
 *
 * Gestiona la actualización de los campos de la tabla de reglas de abastecimiento de los productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class UpdateFieldsToWarehouseInventoryRulesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('warehouse_inventory_rules');
        
        if (!Schema::hasTable('warehouse_inventory_rules')) {
            Schema::create('warehouse_inventory_rules', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('minimum')->unsigned()->nullable()
                      ->comment('Cantidad mínima permitida de un producto en el almacén');
                $table->integer('maximum')->unsigned()->nullable()
                      ->comment('Cantidad máxima permitida de un producto en el almacén');

                $table->integer('warehouse_inventory_product_id')
                      ->comment('Identificador único del producto inventariado');
                $table->foreign('warehouse_inventory_product_id')->references('id')->on('warehouse_inventory_products')
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->integer('user_id')->comment('Identificador único del usuario que registra el cambio de regla');
                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');

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
        Schema::table('warehouse_inventory_rules', function (Blueprint $table) {
        });
    }
}
