<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateTechnicalSupportRequestRepairAssetsTable
 * @brief Crear tabla de bienes institucionales asociados a una solicitud de reparación.
 *
 * Gestiona la creación o eliminación de la tabla de bienes institucionales asociados a una solicitud de reparación.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateTechnicalSupportRequestRepairAssetsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('technical_support_request_repair_assets')) {
            Schema::create('technical_support_request_repair_assets', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->foreignId('asset_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('technical_support_request_repair_id')->comment(
                    'Identificador único de la solcitud de reparación asociada al registro'
                );
                $table->foreign(
                    'technical_support_request_repair_id',
                    'technical_support_request_repair_assets_request_fk'
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
        Schema::dropIfExists('technical_support_request_repair_assets');
    }
}
