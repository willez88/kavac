<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldMorphToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropMorphs('documentable');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->nullableMorphs('documentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropMorphs('documentable');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->morphs('documentable');
        });
    }
}
