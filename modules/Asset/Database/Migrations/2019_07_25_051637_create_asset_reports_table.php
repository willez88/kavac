<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class CreateAssetReportsTable
 * @brief Crear tabla de historico de reportes
 * 
 * Gestiona la creación o eliminación del historico de los reportes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CreateAssetReportsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_reports')) {
            Schema::create('asset_reports', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->string('code', 20)->unique()->comment('Código identificador del reporte');
                
                $table->string('type_report',20)->nullable()->comment('Tipo de reporte');
                $table->string('type_search',20)->nullable()->comment('Tipo de búsqueda');

                $table->integer('asset_type_id')->nullable()->unsigned()->comment('Identificador único del tipo de bien');
                $table->integer('asset_category_id')->nullable()->unsigned()->comment('Identificador único de la categoria de bien');
                $table->integer('asset_subcategory_id')->nullable()->unsigned()->comment('Identificador único de la subcategoria de bien');
                $table->integer('asset_specific_category_id')->nullable()->unsigned()->comment('Identificador único de la categoria especifica de bien');

                $table->integer('department_id')->nullable()->unsigned()->comment('Identificador único del departamento');
                $table->integer('institution_id')->nullable()->unsigned()->comment('Identificador único de la institución');

                $table->integer('mes')->nullable()->unsigned()->comment('Identificador único del mes de busqueda');
                $table->year('year')->nullable()->unsigned()->comment('Año de busqueda');

                $table->date('start_date')->nullable()->unsigned()->comment('Fecha inicial de busqueda');
                $table->date('end_date')->nullable()->unsigned()->comment('Fecha final de busqueda');

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
        Schema::dropIfExists('asset_reports');
    }
}
