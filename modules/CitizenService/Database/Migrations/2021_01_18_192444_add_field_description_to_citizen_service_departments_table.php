<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldDescriptionToCitizenServiceDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_departments', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_departments', 'description')) {
                $table->string('description', 300)->nullable()->comment('Descripción del departamento');
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
        Schema::table('citizen_service_departments', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_departments', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
}
