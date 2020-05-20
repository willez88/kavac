<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequestEventsTable
 * @brief Crear tabla de los eventos ocurridos a bienes solicitados
 *
 * Gestiona la creación o eliminación de la tabla de eventos asociados a bienes solicitados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetRequestEventsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_request_events')) {
            Schema::create('asset_request_events', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('type', 100)->comment('Tipo de evento');
                $table->text('description')->comment('Descripción del evento');

                $table->bigInteger('asset_request_id')
                      ->comment('Identificador único de la solicitud asociada al evento en la tabla asset_requests');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('asset_request_events');
    }
}
