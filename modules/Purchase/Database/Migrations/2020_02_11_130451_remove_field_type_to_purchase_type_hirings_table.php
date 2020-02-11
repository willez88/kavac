<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldTypeToPurchaseTypeHiringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_type_hirings', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_type_hirings', 'type')) {
                $table->dropColumn('type');
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
            if (!Schema::hasColumn('purchase_type_hirings', 'type')) {
                $table->enum('type', ['B', 'O', 'S'])->nullable()
                      ->comment('Tipo de objeto de la empresa. (B)ienes, (O)bras y (S)ervicios');
            }
        });
    }
}
