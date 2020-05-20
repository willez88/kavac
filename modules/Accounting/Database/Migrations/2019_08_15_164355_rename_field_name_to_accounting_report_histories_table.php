<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldNameToAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_report_histories', 'report')) {
                DB::statement(
                    "ALTER TABLE accounting_report_histories CHANGE name report ENUM('1', '2', '3', '4', '5', '6') DEFAULT 1 AFTER url"
                );
                //$table->renameColumn('name', 'report');
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
        //
    }
}
