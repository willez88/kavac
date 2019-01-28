<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetDisincorporationAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_disincorporation_assets')) {
            Schema::create('asset_disincorporation_assets', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('asset_id')->unsigned()->nullable()->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('disincorporation_id')->unsigned()->nullable()->comment('Identificador único de la asignación generada');
                $table->foreign('disincorporation_id')->references('id')->on('asset_disincorporations')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_disincorporation_assets');
    }
}
