<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToBudgetStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_stages', function (Blueprint $table) {
            $table->dropMorphs('sourceable');
        });

        Schema::table('budget_stages', function (Blueprint $table) {
            /** Relación para los documentos de origen que generan la etapa presupuestaria del compromiso,
            solo para los estados (CAU)sado y (PAG)ado */
            $table->nullableMorphs('stageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_stages', function (Blueprint $table) {
            $table->dropMorphs('stageable');
        });

        Schema::table('budget_stages', function (Blueprint $table) {
            $table->morphs('sourceable');
        });
    }
}
