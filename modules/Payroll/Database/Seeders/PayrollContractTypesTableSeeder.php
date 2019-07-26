<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollContractType;

class PayrollContractTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollContractTypes = [
            [
                'name' => 'Suplencia'
            ],
            [
                'name' => 'Tiempo determinado'
            ],
            [
                'name' => 'Tiempo indeterminado'
            ],
            [
                'name' => 'Comisión de servicio'
            ]
        ];

        DB::transaction(function() use ($payrollContractTypes) {
            foreach ($payrollContractTypes as $payrollContractType) {
                PayrollContractType::updateOrCreate(
                    ['name' => $payrollContractType['name']]
                );
            }
        });
    }
}
