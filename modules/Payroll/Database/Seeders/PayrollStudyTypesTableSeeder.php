<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollStudyType;

class PayrollStudyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_study_types = [
            [
                'name' => 'Pregrado', 'description' => null
            ],
            [
                'name' => 'Postgrado', 'description' => null
            ],
            [
                'name' => 'Doctorado', 'description' => null
            ]
        ];

        DB::transaction(function() use ($payroll_study_types) {
            foreach ($payroll_study_types as $study_type) {
                PayrollStaffType::updateOrCreate(
                    ['name' => $study_type['name']],
                    [
                        'description' => $study_type['description']
                    ]
                );
            }
        });
    }
}
