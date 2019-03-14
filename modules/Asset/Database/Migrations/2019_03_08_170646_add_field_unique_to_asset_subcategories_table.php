<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldUniqueToAssetSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_subcategories', function (Blueprint $table) {
            $table->unique(array('asset_category_id', 'code','name'))->comment('Clave única para el registro');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_subcategories', function (Blueprint $table) {

        });
    }
}
