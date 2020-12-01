<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPurchasePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_plans', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->comment(
                    'id del usuario a relacionar con el registro'
                );
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
        Schema::table('purchase_plans', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_plans', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}
