<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldRequirementCitizenServiceRequestTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_request_types', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_request_types', 'requirement')) {
                $table->string('requirement', 300)->nullable()->comment('Descripción de requerimientos de solicitud');
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
        Schema::table('citizen_service_request_types', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_request_types', 'requirement')) {
                $table->dropColumn('requirement');
            }

        });
    }
}
