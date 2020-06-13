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

                $table->foreignId('asset_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->foreignId('technical_support_request_repair_id')->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
    }
}
