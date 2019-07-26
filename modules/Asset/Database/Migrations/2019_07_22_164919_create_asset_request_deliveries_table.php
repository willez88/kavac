<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequestDeliveriesTable
 * @brief Crear tabla de las solicitudes de entrega de equipos
 * 
 * Gestiona la creación o eliminación de las solicitudes de entrega de equipos
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetRequestDeliveriesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_request_deliveries')) {
            Schema::create('asset_request_deliveries', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->text('observation')->nullable()->comment('Observaciones de la entrega');
                
                $table->integer('asset_request_id')->comment('Identificador único de la solicitud asociada a la entrega');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('user_id')->comment('Identificador único del usuario que solicita la entrega');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('asset_request_deliveries');
    }
}
