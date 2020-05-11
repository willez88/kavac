<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCitizenServiceDepartmentIdToCitizenServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_requests', 'citizen_service_department_id')) {
                $table->bigInteger('citizen_service_department_id')->unsigned()->nullable()
                      ->comment('Dirección de departamentos');
                $table->foreign('citizen_service_department_id')
                      ->references('id')->on('citizen_service_departments')
                      ->onDelete('restrict')->onUpdate('cascade');
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
            if (Schema::hasColumn('citizen_service_requests', 'citizen_service_department_id')) {
                $table->dropColumn('citizen_service_department_id');
            }
        });
    }
}
