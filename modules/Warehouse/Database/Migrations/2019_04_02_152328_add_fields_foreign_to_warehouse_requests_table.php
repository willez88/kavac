<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForeignToWarehouseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_requests', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_requests', 'project_id')) {
                $table->dropColumn('project_id');
            }
            if (Schema::hasColumn('warehouse_requests', 'centralized_action_id')) {
                $table->dropColumn('centralized_action_id');
            }
            
            if (!Schema::hasColumn('warehouse_requests', 'motive')) {
                $table->string('motive')->comment('Motivo de la solicitud');
            }            
            if (Schema::hasColumn('warehouse_requests', 'specific_action_id')) {
                $table->foreign('specific_action_id')->references('id')->on('budget_specific_actions')->onDelete('restrict')->onUpdate('cascade');
            }
            if (Schema::hasColumn('warehouse_requests', 'dependence_id')) {
                $table->foreign('dependence_id')->references('id')->on('departments')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('warehouse_requests', function (Blueprint $table) {

        });
    }
}
