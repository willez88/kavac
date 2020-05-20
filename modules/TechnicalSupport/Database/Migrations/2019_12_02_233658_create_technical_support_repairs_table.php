<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateTechnicalSupportRepairsTable
 * @brief Crear tabla de reparaciones de bienes institucionales.
 *
 * Gestiona la creación o eliminación de la tabla de reparaciones de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateTechnicalSupportRepairsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('technical_support_repairs')) {
            Schema::create('technical_support_repairs', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('state')->comment('Estado de la reparación');
                $table->text('result')->nullable()->comment('Descripción de los resultados de la reparación');
                $table->date('start_date')->nullable()->comment('Fecha de inicio de reparación');
                $table->date('end_date')->nullable()->comment('Fecha de culminación de reparación');

                $table->bigInteger('user_id')->unsigned()
                      ->comment('Identificador único del usuario responsable de la reparación');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('technical_support_request_repair_id')->unsigned()
                      ->comment('Identificador único de la solcitud asociada a la reparación');
                $table->foreign(
                    'technical_support_request_repair_id',
                    'technical_support_repairs_request_fk'
                )->references('id')->on(
                    'technical_support_request_repairs'
                )->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_support_repairs');
    }
}
