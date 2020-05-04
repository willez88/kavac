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
            $table->string('name', 200)->nullable()->comment('Name or Social reason');
            $table->string('type_person_juridica', 200)->nullable()->comment('Type of person');
            $table->bigInteger('country_id')->unsigned()->comment('Country of residence');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('estate_id')->unsigned()->comment('Identifier of the Estate in which you reside');
            $table->foreign('estate_id')->references('id')->on('estates')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('city_id')->unsigned()->comment('Identifier of the City in which you reside');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('municipality_id')->unsigned()->comment('Identifier of the Municipality in which you reside');
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('restrict')->onUpdate('cascade');
            $table->bigInteger('parish_id')->unsigned()->comment('Identifier of the parish in which you reside');
            $table->foreign('parish_id')->references('id')->on('parishes')->onDelete('restrict')->onUpdate('cascade');
            $table->string('address', 200)->comment('location of client');
            $table->string('address_tax', 200)->comment('location tax of client');
            $table->string('name_client', 100)->comment('Name of client');
            $table->string('email_client')->unique()->nullable()->comment('Email of client');
            $table->string('phone_client')->nullable()->comment('phone of client');
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
