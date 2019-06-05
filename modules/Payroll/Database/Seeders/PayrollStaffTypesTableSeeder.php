<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollStaffType;

class PayrollStaffTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_staff_types = [
            [
                'name' => 'Personal Fijo a Tiempo Completo', 'description' => null
            ],
            [
                'name' => 'Personal Fijo a Tiempo Parcial', 'description' => null
            ],
            [
                'name' => 'Personal Contratado', 'description' => null
            ]
        ];

        DB::transaction(function() use ($payroll_staff_types) {
            foreach ($payroll_staff_types as $staff_type) {
                PayrollStaffType::updateOrCreate(
                    ['name' => $staff_type['name']],
                    [
                        'description' => $staff_type['description']
                    ]
                );
            }
        });
    }
}
