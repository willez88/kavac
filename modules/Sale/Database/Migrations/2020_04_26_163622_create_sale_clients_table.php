<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_clients', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('rif', 100)->unique()->comment('Rif');
            $table->string('first_name', 100)->comment('Name of client');
            $table->string('last_name', 100)->comment('Last name of client');
            $table->string('name', 200)->nullable()->comment('Name or Social reason');
            $table->string('email')->unique()->nullable()->comment('Email of client');
            $table->string('typeformat', 200)->nullable()->comment('Type of format');
            $table->bigInteger('country_id')->unsigned()->comment('Country of residence');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('parish_id')->unsigned()->comment('Identifier of the parish in which you reside');
            $table->foreign('parish_id')->references('id')->on('parishes')->onDelete('restrict')->onUpdate('cascade');
            $table->string('address', 200)->comment('location of client');
            $table->string('address_tax', 200)->comment('Tax location of the client');
            $table->string('phone')->nullable()->comment('phone of client');
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
        Schema::dropIfExists('sale_clients');
    }
}
