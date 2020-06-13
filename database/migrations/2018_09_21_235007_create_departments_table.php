<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre de la unidad, departamento o dependencia');
                $table->string('acronym', 4)->nullable()
                      ->comment('Siglas de la unidad, departamento o dependencia');
                $table->integer('hierarchy')->default(0)
                      ->comment('Jerarquía de la unidad, departamento o dependencia');
                $table->boolean('issue_requests')->default(true)
                      ->comment('Establece si puede emitir solicitudes de almacén');
                $table->boolean('active')->default(true)
                      ->comment('Indica si se encuentra activa');
                $table->boolean('administrative')->default(false)
                      ->comment('Es una unidad, departamento o dependencia administrativa');
                $table->unsignedBigInteger('parent_id')->nullable()->comment(
                    'Unidad, departamento o dependencia a la cual esta subordinado'
                );
                $table->foreignId('institution_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });

            Schema::table('departments', function (Blueprint $table) {
                $table->foreign('parent_id')->references('id')
                      ->on('departments')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('departments');

        Schema::enableForeignKeyConstraints();
    }
}
