<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollLanguage;

class PayrollLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_languages = [
            [
                'name' => 'Español', 'acronym' => 'es'
            ],
            [
                'name' => 'Inglés', 'acronym' => 'en'
            ]
        ];

        DB::transaction(function() use ($payroll_languages) {
            foreach ($payroll_languages as $language) {
                PayrollLanguage::updateOrCreate(
                    [
                        'name' => $language['name']
                    ],
                    [
                        'acronym' => $language['acronym']
                    ]
                );
            }
        });
    }
}
