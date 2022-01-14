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
        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('first_name')->comment('Nombres');
                $table->string('last_name')->nullable()->comment('Apellidos');
                $table->foreignId('image_id')->nullable()->counstrained()->onUpdate('cascade');
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->foreignId('institution_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
                $table->unsignedBigInteger('employee_id')->nullable()->comment(
                    'Identificador del empleado al que pertenece el perfil'
                );
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
        Schema::dropIfExists('profiles');
    }
}
