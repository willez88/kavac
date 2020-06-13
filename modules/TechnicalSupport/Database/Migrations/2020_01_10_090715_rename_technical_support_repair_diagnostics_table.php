<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTechnicalSupportRepairDiagnosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('technical_support_repair_diagnostics');

        if (!Schema::hasTable('technical_support_diagnostics')) {
            Schema::create('technical_support_diagnostics', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->text('description')->nullable()->comment('Descripción del diagnóstico');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('technical_support_diagnostics');

        if (!Schema::hasTable('technical_support_repair_diagnostics')) {
            Schema::create('technical_support_repair_diagnostics', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->text('description')->nullable()->comment('Descripción del diagnóstico');

                $table->unsignedBigInteger('technical_support_repair_id')->comment(
                    'Identificador único de la reparación asociada al diagnóstico'
                );
                $table->foreign(
                    'technical_support_repair_id',
                    'technical_support_repair_diagnostics_repair_fk'
                )->references('id')->on('technical_support_repairs')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }
}
