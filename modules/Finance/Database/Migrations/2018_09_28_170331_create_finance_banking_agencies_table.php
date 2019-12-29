<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceBankingAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('finance_banking_agencies')) {
            Schema::create('finance_banking_agencies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre de la agencia bancaria');
                $table->text('direction')->comment('Dirección de la agencia bancaria');
                $table->boolean('headquarters')->default(false)->comment('Indica si es la sede principal del banco');
                $table->string('contact_person')->nullable()->comment('Nombre de la persona de contacto');
                $table->string('contact_email')->nullable()->comment('Correo electrónico de la persona de contacto');
                $table->bigInteger('finance_bank_id')->unsigned()
                      ->comment('Identificador del banco al que pertenece la agencia o sucursal');
                $table->foreign('finance_bank_id')->references('id')
                      ->on('finance_banks')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('finance_banking_agencies');
    }
}
