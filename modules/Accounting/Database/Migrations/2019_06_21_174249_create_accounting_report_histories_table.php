<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_report_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->enum('report', [1, 2, 3, 4, 5, 6])->comment('Tipo de reporte generado: (1)Balance de comprobacion, (2)Mayor Analítico, (3) Libro Diario, (4)Libro Auxiliar, (5)Balance general, (6)Estado de resultados');
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_report_histories');
    }
}
