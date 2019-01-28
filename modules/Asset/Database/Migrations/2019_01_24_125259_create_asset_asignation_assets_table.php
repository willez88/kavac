<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAsignationAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_asignation_assets')) {
            Schema::create('asset_asignation_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_id')->unsigned()->nullable()->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asignation_id')->unsigned()->nullable()->comment('Identificador único de la asignación generada');
                $table->foreign('asignation_id')->references('id')->on('asset_asignations')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_asignation_assets');
    }
}
