<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCodeToBudgetSubSpecificFormulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('budget_sub_specific_formulations', 'code')) {
            Schema::table('budget_sub_specific_formulations', function (Blueprint $table) {
                $table->string('code', 20)->unique()->comment('Código único para la formulación');
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
            $table->dropColumn('code');
        });
    }
}
