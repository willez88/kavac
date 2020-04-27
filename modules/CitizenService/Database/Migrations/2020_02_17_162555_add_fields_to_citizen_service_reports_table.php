<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCitizenServiceReportsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_reports', 'type_search')) {
                $table->string('type_search', 20)->nullable()->comment('Tipo de búsqueda');
            }

            if (!Schema::hasColumn('citizen_service_reports', 'date')) {
                $table->date('date')->comment('Fecha de Solicitud');
            }

            if (!Schema::hasColumn('citizen_service_reports', 'start_date')) {
                $table->date('start_date')->nullable()->unsigned()->comment('Fecha inicial de busqueda');
            }

            if (!Schema::hasColumn('citizen_service_reports', 'end_date')) {
                $table->date('end_date')->nullable()->unsigned()->comment('Fecha final de busqueda');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('citizen_service_reports', function (Blueprint $table) {
        });
    }
}
