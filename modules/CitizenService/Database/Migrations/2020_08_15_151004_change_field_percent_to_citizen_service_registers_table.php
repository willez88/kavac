<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldPercentToCitizenServiceRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_registers', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_registers', 'percent')) {
                $table->dropColumn('percent');
            }
        });
        Schema::table('citizen_service_registers', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_registers', 'percent')) {
                $table->integer('percent')->nullable()->comment('Porcentaje de cumplimiento');
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
        Schema::table('citizen_service_registers', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_registers', 'percent')) {
                $table->dropColumn('percent');
            }
        });
        Schema::table('citizen_service_registers', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_registers', 'percent')) {
                $table->string('percent', 10)->nullable()->comment('Porcentaje de cumplimiento');
            }
        });
    }
}
