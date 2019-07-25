<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollSectorType;

class PayrollSectorTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollSectorTypes = [
            [
                'name' => 'Público'
            ],
            [
                'name' => 'Privado'
            ]
        ];

        DB::transaction(function() use ($payrollSectorTypes) {
            foreach ($payrollSectorTypes as $payrollSectorType) {
                PayrollSectorType::updateOrCreate(
                    ['name' => $payrollSectorType['name']]
                );
            }
        });
    }
}
