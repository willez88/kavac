<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldEmailToCitizenServiceRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_registers', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_registers', 'email')) {
                $table->dropUnique(['email']);
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
            if (Schema::hasColumn('citizen_service_registers', 'email')) {
                $table->string('email')->unique()->nullable()->comment('Correo electrónico del responsable')->change();
            }
        });
    }
}
