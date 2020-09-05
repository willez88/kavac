<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleWarehouseMovementsTable
 * @brief Crear tabla de movimientos de almacén
 *
 * Gestiona la creación o eliminación de la tabla de movimientos de almacen registrados
 *
 * @author Daniel Contreras (dcontreras@cenditel.gob.ve)
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseMovementsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_movements')) {
            Schema::create('sale_warehouse_movements', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador del movimiento');

                $table->enum('type', ['C', 'M', 'V'])
                      ->comment('Tipo de movimiento: (C)ompra, (M)ovimiento interno o (V)enta');

                $table->text('description')->nullable()
                      ->comment('Descripción del movimiento de almacén');
                $table->text('observations')->nullable()->comment('Observaciones sobre la operación');
                $table->string('state', 100)->nullable()->comment('Estado de la operación');

                $table->unsignedBigInteger('sale_warehouse_institution_warehouse_initial_id')->nullable()->comment(
                    'Identificador único de la ubicación inicial del producto en la tabla institución-almacén'
                );
                $table->foreign(
                    'sale_warehouse_institution_warehouse_initial_id',
                    'sale_warehouse_movements_institution_warehouse_initial_fk'
                )->references('id')->on(
                    'sale_warehouse_institution_warehouses'
                )->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('sale_warehouse_institution_warehouse_end_id')->nullable()->comment(
                    'Identificador único de la ubicación final del producto en la tabla institución-almacén)'
                );
                $table->foreign(
                    'sale_warehouse_institution_warehouse_end_id',
                    'sale_warehouse_movements_institution_warehouse_end_fk'
                )->references('id')->on(
                    'sale_warehouse_institution_warehouses'
                )->onDelete('restrict')->onUpdate('cascade');


                $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_warehouse_movements');
    }
}
