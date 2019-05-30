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
    }
}
