<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Nombre del tipo o modalidad de compra');
            $table->text('description')->comment('Descripción del tipo de compra de compra');

            $table->bigInteger('purchase_processes_id')->unsigned()->nullable()
                      ->comment('Clave foránea a la relación del proceso de compra');
            $table->foreign('purchase_processes_id')->references('id')
                      ->on('purchase_processes')->onDelete('restrict')
                      ->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_types');
    }
}
