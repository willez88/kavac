<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePayrollScaleRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_scale_requirements', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_scale_requirements', 'payroll_scale_id')) {
                $table->dropForeign(['payroll_scale_id']);
            }
        });
        Schema::dropIfExists('payroll_scale_requirements');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('payroll_scale_requirements')) {
            Schema::create('payroll_scale_requirements', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('Identificador único del registro');

                $table->float('scale_years_minimum')->unsigned()->nullable()
                    ->comment('Cantidad minima de años requeridas por la escala');
                $table->float('scale_years_maximum')->unsigned()->nullable()
                    ->comment('Cantidad minima de años requeridas por la escala');

                $table->foreignId('payroll_scale_id')->constrained()->onDelete('restrict')->onUpdate('cascade');

                $table->nullableMorphs('clasificable', 'payroll_scale_requirements_clasificable_index');
                $table->timestamps();
                $table->softDeletes()->comment('Fecha y hora en la que el registro fue eliminado');
            });
        }
    }
}
