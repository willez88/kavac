<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notification_setting_user')) {
            Schema::create('notification_setting_user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->enum('type', ['N', 'E', 'S'])->default('N')
                      ->comment('Tipo de notificacion. Ej. (N)otify, (E)mail, (S)MS');
                $table->bigInteger('notification_setting_id')->unsigned()->nullable()
                      ->comment('Identificador del usuario');
                $table->foreign('notification_setting_id')->references('id')->on('notification_settings')
                      ->onDelete('cascade')->onUpdate('cascade');
                $table->bigInteger('user_id')->unsigned()->nullable()->comment('Identificador del usuario');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
                $table->unique(['notification_setting_id', 'user_id', 'type'])->comment('Clave única para el registro');
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
        Schema::dropIfExists('notification_setting_user');
    }
}
