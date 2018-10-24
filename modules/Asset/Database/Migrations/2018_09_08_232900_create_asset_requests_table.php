<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetRequestTable
 * @brief Crear tabla Solicitudes de Bienes
 * 
 * Gestiona la creación o eliminación de las Solicitudes de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class CreateAssetRequestsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_requests')) {
            Schema::create('asset_requests', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                $table->integer('type')->nullable()->comment('Identificador único del tipo de solicitud');
                $table->string('motive')->nullable()->comment('Motivo de la solicitud');
                $table->date('delivery_date')->nullable()->comment('Fecha de entrega');
                $table->string('ubication')->nullable()->comment('Ubicación del solicitante');
                $table->string('agent_name')->nullable()->comment('Nombre del Agente Externo');
                $table->string('agent_telf')->nullable()->comment('Telefono del Agente Externo');
                $table->string('agent_email')->nullable()->comment('Correo del Agente Externo');


                /**
                 * Fecha en la que se genera la solicitud
                 */
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_requests');
    }
}
