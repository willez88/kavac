<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldToPayrollNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_nationalities', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_nationalities', 'demonym') && !Schema::hasColumn('payroll_nationalities', 'name')) {
                $table->dropColumn("demonym");
                $table->string('name', 100)
                      ->comment('Nombre de la nacionalidad de la persona');
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
        Schema::table('payroll_nationalities', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_nationalities', 'demonym') && Schema::hasColumn('payroll_nationalities', 'name')) {
                $table->dropColumn("name");
                $table->string('demonym', 100)
                      ->comment('Denominacion de la nacionalidad de la persona');
            }
        });
    }
}
