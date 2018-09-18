<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAsignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('asset_asignations')) {
            Schema::create('asset_asignations', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('asset_id')->unsigned()
                      ->comment('Identificador único del bien asignado');
                               
                $table->integer('staff_id')->unsigned()
                      ->comment('Identificador único del trabajador responsable del bien asignado');

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
        Schema::dropIfExists('asset_asignations');
    }
}
