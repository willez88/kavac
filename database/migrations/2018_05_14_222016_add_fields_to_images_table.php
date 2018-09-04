<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->float('max_width')->nullable();
            $table->float('max_height')->nullable();
            $table->float('min_width')->nullable();
            $table->float('min_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('max_width');
            $table->dropColumn('max_height');
            $table->dropColumn('min_width');
            $table->dropColumn('min_height');
        });
    }
}
