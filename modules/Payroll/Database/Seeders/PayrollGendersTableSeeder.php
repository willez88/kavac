<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollGender;

class PayrollGendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payroll_genders = [
            [
                'name' => 'Masculino'
            ],
            [
                'name' => 'Femenino'
            ]
        ];

        DB::transaction(function() use ($payroll_genders) {
            foreach ($payroll_genders as $gender) {
                PayrollGender::updateOrCreate(
                    ['name' => $gender['name']]
                );
            }
        });
    }
}
