<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequestsTable
 * @brief Crear tabla de las solicitudes de bienes institucionales
 *
 * Gestiona la creación o eliminación de la tabla de solicitudes de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateAssetRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_requests')) {
            Schema::create('asset_requests', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('code', 20)->unique()->comment('Código identificador de la solicitud');
                $table->integer('type')->nullable()->comment('Identificador único del tipo de solicitud');
                $table->string('motive')->nullable()->comment('Motivo de la solicitud');
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->date('delivery_date')->nullable()->comment('Fecha de entrega');
                $table->string('agent_name')->nullable()->comment('Nombre del agente externo');
                $table->string('agent_telf')->nullable()->comment('Teléfono del agente externo');
                $table->string('agent_email')->nullable()->comment('Correo del agente externo');

                $table->bigInteger('user_id')->comment('Identificador único del usuario que realiza la solicitud');
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
        Schema::dropIfExists('asset_requests');
    }
}
