<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('finance_banks')) {
            Schema::create('finance_banks', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 4)->unique()->comment('Codigo de la entidad bancaria');
                $table->string('name', 100)->unique()->comment('Nombre del banco');
                $table->string('short_name', 50)->comment('Nombre corto del banco');
                $table->string('website')->nullable()->comment('Sitio web del banco');
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
        Schema::dropIfExists('finance_banks');
    }
}
