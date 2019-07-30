<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollNationality;
use Modules\Payroll\Models\Country as BaseCountry;

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
                'name' => 'Venezolano(a)', 
                'country_id' => BaseCountry::where('name', 'Venezuela')->first()
            ],
        ];

        DB::transaction(function() use ($payroll_nationalities) {
            foreach ($payroll_nationalities as $nationality) {
                if (!is_null($nationality['country_id'])) {
                    PayrollNationality::updateOrCreate(
                        [
                            'country_id' => $nationality['country_id']->id
                        ],
                        [
                            'name' => $nationality['name']
                        ]
                    );
                }
            }
        });
    }
}
