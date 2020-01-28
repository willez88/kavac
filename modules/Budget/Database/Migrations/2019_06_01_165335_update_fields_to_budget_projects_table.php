<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToBudgetProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_projects', function (Blueprint $table) {
            $table->bigInteger('payroll_position_id')->unsigned()->nullable()
                  ->comment(
                      'Identificador asociado al cargo de la persona responsable del proyecto'
                  )->change();
            $table->bigInteger('payroll_staff_id')->unsigned()->nullable()
                  ->comment(
                      'Identificador asociado al cargo de la persona responsable del proyecto'
                  )->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_projects', function (Blueprint $table) {
            $table->bigInteger('payroll_position_id')->unsigned()
                  ->comment(
                      'Identificador asociado al cargo de la persona responsable del proyecto'
                  )->change();
            $table->bigInteger('payroll_staff_id')->unsigned()
                  ->comment(
                      'Identificador asociado al cargo de la persona responsable del proyecto'
                  )->change();
        });
    }
}
