<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInstitutionIdToFiscalYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscal_years', function (Blueprint $table) {
            if (!Schema::hasColumn('fiscal_years', 'institution_id')) {
                $table->bigInteger('institution_id')->unsigned()->nullable()
                      ->comment('Identificador de la institución');
                $table->foreign('institution_id')->references('id')
                      ->on('institutions')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('fiscal_years', function (Blueprint $table) {
            if (Schema::hasColumn('fiscal_years', 'institution_id')) {
                $table->dropForeign(['institution_id']);
                $table->dropColumn('institution_id');
            }
        });
    }
}
