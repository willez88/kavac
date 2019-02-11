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


class CreateWarehouseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('warehouse_requests')) {
            Schema::create('warehouse_requests', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->string('observation')->nullable()->comment('Observaciones de la solicitud');

                $table->boolean('delivered')->default(false)->comment('Campo que indica si el almacén hizo entrega de la solicitud');
                $table->date('delivery_date')->nullable()->comment('Fecha de entrega de la solicitud');

                /*No pueden ser nulos*/
                $table->integer('activity_id')->nullable()->comment('Identificador único de la actividad a la que se asocia la solicitud');

                $table->integer('project_id')->nullable()->comment('Identificador único del proyecto al que se asocia la solicitud');
                $table->integer('centralized_action_id')->nullable()->comment('Identificador único de la acción centralizada asociada a la solicitud');
                $table->integer('specific_action_id')->nullable()->comment('Identificador único de la acción centralizada asociada a la solicitud');

                $table->integer('dependence_id')->nullable()->comment('Identificador único de la dependencia que solicita los articulos');

                /**
                 * Fecha en la que se genera la solicitud
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_requests');
    }
}
