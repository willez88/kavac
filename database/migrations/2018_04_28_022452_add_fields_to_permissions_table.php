<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'model_prefix')) {
                $table->string('model_prefix', 100)->nullable()->comment('Prefijo del modelo');
            }
            if (!Schema::hasColumn('permissions', 'slug_alt')) {
                $table->string('slug_alt', 50)->nullable()->comment('Slug alternativo');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('model_prefix');
            $table->dropColumn('slug_alt');
        });
    }
}
