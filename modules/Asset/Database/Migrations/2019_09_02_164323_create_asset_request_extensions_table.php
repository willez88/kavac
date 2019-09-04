<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequestExtensionsTable
 * @brief Crear tabla de las solicitudes de prorrogas de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de solicitudes de prorrogas de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetRequestExtensionsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_request_extensions')) {
            Schema::create('asset_request_extensions', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->date('delivery_date')->comment('Nueva fecha de entrega de la solicitud asociada');
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->integer('asset_request_id')
                      ->comment('Identificador único de la solicitud asociada a la prorroga');
                $table->foreign('asset_request_id')->references('id')->on('asset_requests')
                      ->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('user_id')->comment('Identificador único del usuario que solicita la prorroga');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_request_extensions');
    }
}
