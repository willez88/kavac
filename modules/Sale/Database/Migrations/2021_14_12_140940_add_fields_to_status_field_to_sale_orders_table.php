<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToStatusFieldToSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('sale_orders')) {
        Schema::table('sale_orders', function (Blueprint $table) {
          if (!Schema::hasColumn('sale_orders', 'status')) {
            $table->json('status')->nullable()->comment('Status de la solicitud');
          }
          if (!Schema::hasColumn('sale_orders', 'id_number')) {
            $table->json('id_number')->nullable()->comment('Status de la solicitud');
          }
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
      Schema::table('sale_orders', function (Blueprint $table) {
        if (Schema::hasColumn('sale_orders', 'status')) {
          $table->dropColumn('status');
        }
        if (Schema::hasColumn('sale_orders', 'id_number')) {
          $table->dropColumn('id_number');
        }
      });
    }
}
