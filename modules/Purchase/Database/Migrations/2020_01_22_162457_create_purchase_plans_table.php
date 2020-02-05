<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_plans')) {
            Schema::create('purchase_plans', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('init_date')->nullable()->comment('Fecha de inicio del plan de compras');
                $table->date('end_date')->nullable()->comment('Fecha de culminación del plan de compras');

                $table->bigInteger('purchase_processes_id')->unsigned()
                      ->comment('Clave foránea a la relación del proceso de compra');
                $table->foreign('purchase_processes_id')->references('id')
                      ->on('purchase_processes')->onDelete('restrict')
                      ->onUpdate('cascade');

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
        Schema::dropIfExists('purchase_plans');
    }
}