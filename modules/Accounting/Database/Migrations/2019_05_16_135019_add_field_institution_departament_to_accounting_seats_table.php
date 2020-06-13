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
            $table->foreignId('institution_id')->nullable()->constrained()->onDelete('cascade')->comment(
                'id de la institución que genero el asiento contable'
            );

            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade')->comment(
                'id del departamento de institución que genero el asiento contable'
            );
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
