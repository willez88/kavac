<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollLanguageLevel;

class PayrollLanguageLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_language_levels = [
            [
                'name' => 'Básico'
            ],
            [
                'name' => 'Intermedio'
            ],
            [
                'name' => 'Doctorado'
            ]
        ];

        DB::transaction(function() use ($payroll_language_levels) {
            foreach ($payroll_language_levels as $language_level) {
                PayrollStaffType::updateOrCreate(
                    ['name' => $language_level['name']]
                );
            }
        });
    }
}
