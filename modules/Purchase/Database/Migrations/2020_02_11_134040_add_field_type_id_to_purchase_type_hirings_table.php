<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTypeIdToPurchaseTypeHiringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_type_hirings', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_type_hirings', 'purchase_type_operation_id')) {
                $table->integer('purchase_type_operation_id')->unsigned()->nullable()
                      ->comment('Tipo de objeto de la empresa. (B)ienes, (O)bras y (S)ervicios');
                $table->foreign('purchase_type_operation_id')->references('id')
                      ->on('purchase_type_operations')->onDelete('cascade')
                      ->onUpdate('cascade');
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
        Schema::table('purchase_type_hirings', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_type_hirings', 'purchase_type_operation_id')) {
                $table->dropColumn('purchase_type_operation_id');
            }
        });
    }
}
