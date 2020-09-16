<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleSettingDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_setting_deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('name')->comment('Nombre');
            $table->string('description')->comment('Descripción');
            $table->string('deposit_attributes')->comment('Atributos');

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
        Schema::dropIfExists('sale_setting_deposits');
    }
}
