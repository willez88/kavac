<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInstitutionIdToAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_report_histories', 'institution_id')) {
                $table->foreignId('institution_id')->nullable()->constrained()->onDelete('cascade')->comment(
                    'id de la institucion a relacionar con el registro'
                );
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
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            if (Schema::hasColumn('accounting_report_histories', 'institution_id')) {
                $table->dropColumn('institution_id');
            }
        });
    }
}
