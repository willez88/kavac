<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PayrollDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /** Seeder para roles y permisos disponibles en el módulo */
        $this->call(PayrollRoleAndPermissionsTableSeeder::class);

        /** Seeder para tipos de personal disponibles en el módulo */
        $this->call(PayrollStaffTypesTableSeeder::class);

        /** Seeder para los géneros disponibles en el módulo */
        $this->call(PayrollGendersTableSeeder::class);

        /** Seeder para las nacionalidades disponibles en el módulo */
        $this->call(PayrollNationalitiesTableSeeder::class);

        /** Seeder para los grados de instrucción disponibles en el módulo */
        $this->call(PayrollInstructionDegreesTableSeeder::class);

        /** Seeder para los tipos de estudio disponibles en el módulo */
        $this->call(PayrollStudyTypesTableSeeder::class);

        /** Seeder para los niveles de idioma disponibles en el módulo */
        $this->call(PayrollLanguageLevelsTableSeeder::class);

        /** Seeder para los idiomas disponibles en el módulo */
        $this->call(PayrollLanguagesTableSeeder::class);

        /** Seeder para los tipos de contrato disponibles en el módulo */
        $this->call(PayrollContractTypesTableSeeder::class);

        /** Seeder para los tipos de sectores disponibles en el módulo */
        $this->call(PayrollSectorTypesTableSeeder::class);

        /** Seeder para los tipos de inactividad disponibles en el módulo */
        $this->call(PayrollInactivityTypesTableSeeder::class);

        /** Seeder para los tipos de asignacion disponibles en el módulo */
        $this->call(PayrollSalaryAssignmentTypeTableSeeder::class);
    }
}
