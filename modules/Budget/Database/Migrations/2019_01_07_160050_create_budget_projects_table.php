<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('budget_projects')) {
            Schema::create('budget_projects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('Nombre del Proyecto');
                $table->string('code')->unique()->comment('Código del Proyecto');
                $table->string('onapre_code')->nullable()->comment('Código otorgado por la ONAPRE');
                $table->boolean('active')->default(true)->comment('Indica si el proyecto esta activo');
                $table->foreignId('department_id')->constrained()->onUpdate('cascade');
                $table->foreignId('payroll_position_id')->constrained()->onUpdate('cascade');
                $table->foreignId('payroll_staff_id')->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('budget_projects');
    }
}
