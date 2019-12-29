<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('phones')) {
            Schema::create('phones', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('area_code')->comment('Código de área');
                $table->string('number')->comment('Número telefónico');
                $table->enum('type', ['M', 'T', 'F'])->default('T')
                      ->comment('Tipo de teléfono: (M)óvil, (T)eléfono, (F)ax');
                $table->string('extension')->nullable()->comment('Número de extensión (si posee)');
                $table->morphs('phoneable');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
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
        Schema::dropIfExists('phones');
    }
}
