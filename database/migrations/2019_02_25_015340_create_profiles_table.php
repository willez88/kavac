<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->comment('Nombres');
            $table->string('last_name')->nullable()->comment('Apellidos');
            $table->integer('image_id')->nullable()->unsigned()
                  ->comment('Identificador asociado a la imagen de perfil');
            $table->foreign('image_id')->references('id')->on('images')->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->nullable()
                  ->comment('Identificador del usuario');
            $table->foreign('user_id')->references('id')
                  ->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('profiles');
    }
}
