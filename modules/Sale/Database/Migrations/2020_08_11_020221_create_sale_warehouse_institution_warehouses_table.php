<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleWarehouseInstitutionWarehousesTable
 * @brief Crear tabla intermedia de instituciones y almacenes
 *
 * Gestiona la creación o eliminación de la tabla intermedia de instituciones y almacenes
 *
 * @author dcontreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseInstitutionWarehousesTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  dcontreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_institution_warehouses')) {
            Schema::create('sale_warehouse_institution_warehouses', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->foreignId('institution_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('sale_warehouses_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->boolean('main')->default(false)
                      ->comment('Define si es el almacen principal');
                $table->boolean('manage')->default(true)
                      ->comment('Estatus de gestión. (true) activo, (false) inactivo');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author dcontreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_warehouse_institution_warehouses');
    }
}
