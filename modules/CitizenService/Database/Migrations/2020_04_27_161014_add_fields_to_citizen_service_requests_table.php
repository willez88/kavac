<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCitizenServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_requests', 'type_team')) {
                $table->string('type_team', 200)->nullable()->comment('Tipo de equipo');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'brand')) {
                $table->string('brand', 100)->nullable()->comment('Marca');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'model')) {
                $table->string('model', 100)->nullable()->comment('Modelo');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'serial')) {
                $table->string('serial', 100)->nullable()->comment('Serial');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'color')) {
                $table->string('color', 100)->nullable()->comment('Color');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'transfer')) {
                $table->string('transfer', 200)->nullable()->comment('Motivo de traslado');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'code')) {
                $table->string('code', 100)->nullable()->comment('Codigo de inventario');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'entryhour')) {
                $table->string('entryhour', 100)->nullable()->comment('Hora de entrada');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'exithour')) {
                $table->string('exithour', 100)->nullable()->comment('Hora de salida');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'informationteam')) {
                $table->string('informationteam', 200)->nullable()->comment('Información adicional del equipo');
            }
            if (!Schema::hasColumn('citizen_service_requests', 'type_institution')) {
                $table->boolean('type_institution')->default(false)->comment('Establece si es institución o no');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_requests', 'type_team')) {
                $table->dropColumn(['type_team']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'brand')) {
                $table->dropColumn(['brand']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'model')) {
                $table->dropColumn(['model']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'serial')) {
                $table->dropColumn(['serial']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'color')) {
                $table->dropColumn(['color']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'transfer')) {
                $table->dropColumn(['transfer']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'code')) {
                $table->dropColumn(['code']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'entryhour')) {
                $table->dropColumn(['entryhour']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'exithour')) {
                $table->dropColumn(['exithour']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'informationteam')) {
                $table->dropColumn(['informationteam']);
            }
            if (Schema::hasColumn('citizen_service_requests', 'type_institution')) {
                $table->dropColumn(['type_institution']);
            }


        });
    }
}
