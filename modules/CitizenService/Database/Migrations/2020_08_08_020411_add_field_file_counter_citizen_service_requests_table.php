<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldFileCounterCitizenServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('citizen_service_requests', 'file_counter')) {
                $table->integer('file_counter')->default(0)
                ->comment('Contador de arcivo');
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
            if (Schema::hasColumn('citizen_service_requests', 'file_counter')) {
                $table->dropColumn('file_counter');
            }

        });
    }
}
