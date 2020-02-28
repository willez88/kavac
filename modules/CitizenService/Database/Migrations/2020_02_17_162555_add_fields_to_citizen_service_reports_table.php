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
            $table->string('type_search', 20)->nullable()->comment('Tipo de búsqueda');

            $table->date('date')->comment('Fecha de Solicitud');

            $table->date('start_date')->nullable()->unsigned()->comment('Fecha inicial de busqueda');
            $table->date('end_date')->nullable()->unsigned()->comment('Fecha final de busqueda');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
