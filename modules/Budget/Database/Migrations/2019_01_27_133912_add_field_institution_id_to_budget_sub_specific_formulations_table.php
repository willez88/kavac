<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInstitutionIdToBudgetSubSpecificFormulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('budget_sub_specific_formulations', 'institution_id')) {
            Schema::table('budget_sub_specific_formulations', function (Blueprint $table) {
                $table->bigInteger('institution_id')->unsigned()->nullable()
                      ->comment('Identificador asociado a la institución');
                $table->foreign('institution_id')->references('id')->on('institutions')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_sub_specific_formulations', function (Blueprint $table) {
            $table->dropForeign('budget_sub_specific_formulations_institution_id_foreign');
            $table->dropColumn('institution_id');
        });
    }
}
