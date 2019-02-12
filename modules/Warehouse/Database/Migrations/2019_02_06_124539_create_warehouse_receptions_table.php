<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * @class CreateWarehouseRequestTable
 * @brief Crear tabla Solicitudes de Almacen
 * 
 * Gestiona la creación o eliminación de las Solicitudes de artículos al Almacenes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */


class CreateWarehouseReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_receptions')) {
            Schema::create('warehouse_receptions', function (Blueprint $table) {
                
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->integer('type')->nullable()->comment('Tipo de operación de la recepción (0 => Compras,1 => Movimientos de Almacén)');
                $table->string('motive')->nullable()->comment('Observaciones de la solicitud');
                $table->integer('state')->nullable()->comment('Estado de la solicitud');

                $table->integer('warehouse_id')->comment('Identificador único del almacen que recibe los artículos');
                 $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('warehouse_receptions');
    }
}
