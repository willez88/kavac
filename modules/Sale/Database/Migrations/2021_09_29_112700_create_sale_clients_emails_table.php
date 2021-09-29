<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleClientsEmailsTable
 * @brief Crear tabla de los correos electrónicos del cliente
 *
 * Gestiona la creación o eliminación de la tabla de correo electrónico del cliente
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleClientsEmailsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_clients_emails')) {
            Schema::create('sale_clients_emails', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('email', 100)->nullable()
                      ->comment('Correo electrónico del cliente');

                $table->foreignId('sale_client_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_clients_emails');
    }
}
