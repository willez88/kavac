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
        Schema::disableForeignKeyConstraints();
        if (!Schema::hasTable('technical_support_request_repair_assets')) {
            Schema::create('technical_support_request_repair_assets', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->foreignId('asset_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->unsignedBigInteger('technical_support_request_repair_id')->comment(
                    'Identificador único de la solcitud de reparación asociada al registro'
                );
                $table->foreign(
                    'technical_support_request_repair_id',
                    'technical_support_request_repair_assets_fk'
                )->references('id')->on('technical_support_request_repairs')->onDelete('restrict')->onUpdate('cascade');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        };
        Schema::enableForeignKeyConstraints();
    }
}
