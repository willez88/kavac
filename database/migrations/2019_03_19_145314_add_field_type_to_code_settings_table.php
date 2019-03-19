<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTypeToCodeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_settings', function (Blueprint $table) {
            $table->string('type')->nullable()
                  ->comment("Define un tipo de registro en caso de que en un mismo modelo se registre distinta información");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('code_settings', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
