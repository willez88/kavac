<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateSaleReportsTable
 * @brief Crea los campos de la tabla de reportes de inventario de productos 
 * de comercialización
 *
 * Gestiona la creación o eliminación de los campos de la tabla de reportes de inventario
 * de productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CreateSaleWarehouseReportsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sale_warehouse_reports')) {
            Schema::create('sale_warehouse_reports', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->string('code', 20)->unique()->comment('Código identificador del reporte');

                $table->string('type_report', 20)->nullable()->comment('Tipo de reporte');

                $table->foreignId('institution_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade')
                      ->comment('Identificador único de la institución asociada al reporte');

                $table->string('filename')->nullable()->comment('nombre del documento');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }

    /**
     * Método que elimina las migraciones
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_warehouse_reports');
    }
}
