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

            $table->foreignId('country_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('estate_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('municipality_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('parish_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

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
