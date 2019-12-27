<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldStatusToPurchaseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirements', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirements', 'requirement_status')) {
                $table->enum('requirement_status', ['WAIT', 'PROCESSED', 'BOUGHT'])->default('WAIT')
                      ->comment(
                          'Determina el estatus del requerimiento 
                          (WAIT) - en espera. 
                          (PROCESSED) - Procesado,
                          (BOUGHT) - comprado',
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
        Schema::table('purchase_requirements', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requirements', 'requirement_status')) {
                $table->dropColumn('requirement_status');
            }
        });
    }
}
