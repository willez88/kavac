<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetRequestedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_requesteds')) {
            Schema::create('asset_requesteds', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');

                $table->integer('inventary_id')->unsigned()->comment('Identificador único del bien en la tabla de inventario de bienes');
                $table->foreign('inventary_id')->references('id')->on('asset_inventaries')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('asset_id')->unsigned()->comment('Identificador único del bien en la tabla de bienes');
                $table->foreign('asset_id')->references('id')->on('assets')->onDelete('restrict')->onUpdate('cascade');

                $table->integer('request_id')->unsigned()->comment('Identificador único de la solicitud generada');
                $table->foreign('request_id')->references('id')->on('asset_requests')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_requesteds');
    }
}
