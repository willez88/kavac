<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldNationalityIdToPayrollStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_staffs', function (Blueprint $table) {
            $table->integer('payroll_nationality_id')->unsigned()->nullable()
                  ->comment('identificador de nacionalidad que pertenece al personal');
            $table->foreign('payroll_nationality_id')->references('id')->on('payroll_nationalities')
                  ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_staffs', function (Blueprint $table) {
            $table->dropForeign('payroll_staffs_payroll_nationality_id_foreign');
            $table->dropColumn('payroll_nationality_id');
        });
    }
}
