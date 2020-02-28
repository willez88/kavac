<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTechnicalSupportRequestRepairAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('technical_support_request_repair_assets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('technical_support_request_repair_assets')) {
            Schema::create('technical_support_request_repair_assets', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->bigInteger('asset_id')->unsigned()
                    ->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->bigInteger('technical_support_request_repair_id')->unsigned()
                    ->comment('Identificador único de la solcitud de reparación asociada al registro');
                $table->foreign('technical_support_request_repair_id')->references('id')
                    ->on('technical_support_request_repairs')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }
}
