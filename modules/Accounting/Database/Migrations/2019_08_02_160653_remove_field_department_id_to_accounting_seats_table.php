<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldDepartmentIdToAccountingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->nullable()->comment('id del departamento de institución que genero el asiento contable');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->comment('id del departamento de institución que genero el asiento contable');
        });
    }
}
