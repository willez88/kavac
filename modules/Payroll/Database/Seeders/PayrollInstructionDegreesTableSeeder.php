<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollInstructionDegree;

class PayrollInstructionDegreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_instruction_degrees = [
            [
                'name' => 'Primaria', 'description' => null
            ],
            [
                'name' => 'Bachillerato', 'description' => null
            ],
            [
                'name' => 'Técnico Medio', 'description' => null
            ],
            [
                'name' => 'TSU Universitario', 'description' => null
            ],
            [
                'name' => 'Universitario Pregrado', 'description' => null
            ],
            [
                'name' => 'Especialización', 'description' => null
            ],
            [
                'name' => 'Maestría', 'description' => null
            ],
            [
                'name' => 'Doctorado', 'description' => null
            ]
        ];

        DB::transaction(function() use ($payroll_instruction_degrees) {
            foreach ($payroll_instruction_degrees as $instruction_degree) {
                PayrollInstructionDegree::updateOrCreate(
                    ['name' => $instruction_degree['name']],
                    [
                        'description' => $instruction_degree['description']
                    ]
                );
            }
        });
    }
}
