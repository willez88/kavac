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
            $table->float('max-height')->nullable();
            $table->float('min-width')->nullable();
            $table->float('min-height')->nullable();
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
            $table->dropColumn('max-width');
            $table->dropColumn('max-height');
            $table->dropColumn('min-width');
            $table->dropColumn('min-height');
        });
    }
}
