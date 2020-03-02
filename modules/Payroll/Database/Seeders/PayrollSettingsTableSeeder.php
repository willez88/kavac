<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\Parameter;

class PayrollSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::transaction(function () {
            Parameter::updateOrCreate(
                [
                    'p_key' => 'work_age',
                    'required_by' => 'payroll',
                    'active' => true
                ],
                [
                    'p_key' => 'work_age',
                    'p_value' => '16',
                    'required_by' => 'payroll',
                ]
            );
        });
    }
}
