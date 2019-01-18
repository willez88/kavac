<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetRequestEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_request_events')) {
            Schema::create('asset_request_events', function (Blueprint $table) {
                $table->increments('id')->comment('Identificador único del registro');
                
                $table->string('type',100)->comment('Nombre del tipo de evento');
                $table->string('description',100)->comment('Descripción del evento');
                
                $table->integer('request_id')->comment('Identificador único de la solicitud asociada al evento en la tabla asset_requests');
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
        Schema::dropIfExists('asset_request_events');
    }
}
