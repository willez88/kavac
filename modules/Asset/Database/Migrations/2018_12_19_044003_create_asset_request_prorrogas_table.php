<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetRequestProrrogasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_request_prorrogas')) {
            Schema::create('asset_request_prorrogas', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->date('delivery_date')->comment('Nueva fecha de entrega de la solicitud asociada');
                $table->string('state')->nullable()->comment('Estado de la solicitud');
                $table->integer('request_id')->comment('Identificador único de la solicitud asociada al evento en la tabla asset_requests');
                $table->foreign('request_id')->references('id')->on('asset_requests')->onDelete('restrict')->onUpdate('cascade');
                $table->integer('user_id')->comment('Identificador único del usuario que solicita la prorroga');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('asset_request_prorrogas');
    }
}
