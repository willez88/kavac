<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCitiableMorphsFieldToCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('cities', ['citiable_id', 'ciatiable_type'])) {
            Schema::table('cities', function (Blueprint $table) {
                $table->nullableMorphs('citiable');
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
        Schema::table('cities', function (Blueprint $table) {
            if (Schema::hasColumns('cities', ['citiable_id', 'ciatiable_type'])) {
                $table->dropColumn('citiable_id');
                $table->dropColumn('citiable_type');
            }
        });
    }
}
