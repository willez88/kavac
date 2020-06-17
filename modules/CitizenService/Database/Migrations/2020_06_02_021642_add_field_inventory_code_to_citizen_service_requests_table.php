<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInventoryCodeToCitizenServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_service_requests', function (Blueprint $table){
           
            if (!Schema::hasColumn('citizen_service_requests', 'inventory_code')) {
                $table->string('inventory_code', 100)->nullable()->comment('Codigo de inventario');
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
        Schema::table('citizen_service_requests', function (Blueprint $table) {
            if (Schema::hasColumn('citizen_service_requests', 'inventory_code')) {
                $table->dropColumn('inventory_code');
            }
        });
    }
}
