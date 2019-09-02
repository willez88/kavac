<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResetAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('accounting_report_histories')) {
            Schema::dropIfExists('accounting_report_histories');

            Schema::create('accounting_report_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('url');
                $table->string('report')->comment('Tipo de reporte')
                ->comment(
                    'Tipo de reporte generado: (1)Balance de comprobacion, 
                    (2)Mayor Analítico, (3) Libro Diario, (4)Libro Auxiliar,
                     (5)Balance general, (6)Estado de resultados'
                );
                $table->timestamps();
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
        if (!Schema::hasTable('accounting_report_histories')) {
            Schema::create('accounting_report_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('url');
                $table->string('report')->comment('Tipo de reporte')
                ->comment(
                    'Tipo de reporte generado: (1)Balance de comprobacion, 
                    (2)Mayor Analítico, (3) Libro Diario, (4)Libro Auxiliar,
                     (5)Balance general, (6)Estado de resultados'
                );
                $table->timestamps();
            });
        }
    }
}
