<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @class AddFieldsToPayrollStaffsTable
 * @brief Crear varios campos a la información personal del trabajador
 *
 * Gestiona la creación o eliminación de un campo de la tabla información personal del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AddFieldsToPayrollStaffsTable extends Migration
{
    /**
     * Método que ejecuta las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_staffs', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_staffs', 'has_disability')) {
                $table->boolean('has_disability')->default(false)->comment('¿Posee una discapacidad?');
            }

            if (!Schema::hasColumn('payroll_staffs', 'disability')) {
                $table->string('disability', 200)->nullable()->comment('Descripción de la discapacidad');
            }

            if (!Schema::hasColumn('payroll_staffs', 'social_security')) {
                $table->string('social_security', 20)->nullable()->comment('Número del seguro social');
            }

            if (!Schema::hasColumn('payroll_staffs', 'has_driver_license')) {
                $table->boolean('has_driver_license')->default(true)->comment('¿Posee licencia de conducir?');
            }

            if (!Schema::hasColumn('payroll_staffs', 'payroll_license_degree_id')) {
                $table->foreignId('payroll_license_degree_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }

            if (!Schema::hasColumn('payroll_staffs', 'payroll_blood_type_id')) {
                $table->foreignId('payroll_blood_type_id')->nullable()->constrained()
                      ->onDelete('restrict')->onUpdate('cascade');
            }
        });
    }

    /**
     * Método que elimina las migraciones
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_staffs', function (Blueprint $table) {
            if (Schema::hasColumn('payroll_staffs', 'has_disability')) {
                $table->dropColumn('has_disability');
            }

            if (Schema::hasColumn('payroll_staffs', 'disability')) {
                $table->dropColumn('disability');
            }

            if (Schema::hasColumn('payroll_staffs', 'social_security')) {
                $table->dropColumn('social_security');
            }

            if (Schema::hasColumn('payroll_staffs', 'has_driver_license')) {
                $table->dropColumn('has_driver_license');
            }

            if (Schema::hasColumn('payroll_staffs', 'payroll_license_degree_id')) {
                $table->dropColumn('payroll_license_degree_id');
            }

            if (Schema::hasColumn('payroll_staffs', 'payroll_blood_type_id')) {
                $table->dropColumn('payroll_blood_type_id');
            }
        });
    }
}
