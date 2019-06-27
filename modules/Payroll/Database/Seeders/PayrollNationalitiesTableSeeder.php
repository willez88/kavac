<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollNationality;

class PayrollNationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_nationalities = [
            [
                'name' => 'Venezolano(a)', 'country_id' => 1
            ],
        ];

        DB::transaction(function() use ($payroll_nationalities) {
            foreach ($payroll_nationalities as $nationality) {
                PayrollNationality::updateOrCreate(
                    [
                        'country_id' => $nationality['country_id']
                    ],
                    [
                        'name' => $nationality['name'], 'country_id' => $nationality['country_id']
                    ]
                );
            }
        });
    }
}
