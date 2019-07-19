<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollInactivityType;

class PayrollInactivityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_inactivity_types = [
            [
                'name' => 'Permiso no remunerado'
            ],
            [
                'name' => 'Comisión de permiso'
            ],
            [
                'name' => 'Año sabático'
            ],
            [
                'name' => 'Renuncia'
            ],
            [
                'name' => 'Jubilado'
            ]
        ];

        DB::transaction(function() use ($payroll_inactivity_types) {
            foreach ($payroll_inactivity_types as $payroll_inactivity_type) {
                PayrollInactivityType::updateOrCreate(
                    ['name' => $payroll_inactivity_type['name']]
                );
            }
        });
    }
}
