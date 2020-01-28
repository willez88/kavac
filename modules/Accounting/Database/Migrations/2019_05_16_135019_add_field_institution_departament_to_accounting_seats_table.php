<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInstitutionDepartamentToAccountingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_seats', function (Blueprint $table) {
            $table->bigInteger('institution_id')->unsigned()->nullable()->comment('id de la institución que genero el asiento contable');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade')->comment('id de la institución que genero el asiento contable');

            $table->bigInteger('department_id')->unsigned()->nullable()->comment('id del departamento de institución que genero el asiento contable');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->comment('id del departamento de institución que genero el asiento contable');
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
            $table->dropColumn(['institution_id', 'department_id']);
        });
    }
}
