<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldDeleteAtToAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_report_histories', function (Blueprint $table) {
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        });
    }
}
