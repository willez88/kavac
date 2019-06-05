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
                'demonym' => 'Venezolano(a)', 'country_id' => 1
            ]
        ];

        DB::transaction(function() use ($payroll_nationalities) {
            foreach ($payroll_nationalities as $nationality) {
                PayrollNationality::updateOrCreate(
                    ['demonym' => $nationality['demonym']],
                    [
                        'country_id' => $nationality['country_id']
                    ]
                );
            }
        });
    }
}
