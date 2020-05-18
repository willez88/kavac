<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicalSupportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('technical_support_requests')) {
            Schema::create('technical_support_requests', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');
                $table->string('state')->comment('Estado de la solicitud');
                $table->text('description')->comment('Descripción de la avería del bien');

                $table->bigInteger('user_id')->comment('Identificador único del usuario que solicita la reparación');

                $table->bigInteger('asset_id')
                      ->comment('Identificador único del bien asociado a la solicitud de reparación');

                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');

                $table->foreign('user_id')->references('id')->on('users')
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->foreign('asset_id')->references('id')
                      ->on('assets')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('technical_support_requests');
    }
}
