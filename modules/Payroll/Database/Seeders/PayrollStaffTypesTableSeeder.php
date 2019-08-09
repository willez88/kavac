<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollStaffType;

/**
 * @class PayrollStaffTypesTableSeeder
 * @brief Inicializar los tipos de personal
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollStaffTypesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los tipos de personal
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollStaffTypes = [
            [
                'name' => 'Personal Fijo a Tiempo Completo', 'description' => ''
            ],
            [
                'name' => 'Personal Fijo a Tiempo Parcial', 'description' => ''
            ],
            [
                'name' => 'Personal Contratado', 'description' => ''
            ]
        ];

        DB::transaction(function() use ($payrollStaffTypes) {
            foreach ($payrollStaffTypes as $payrollStaffType) {
                PayrollStaffType::updateOrCreate(
                    ['name' => $payrollStaffType['name']],
                    [
                        'description' => $payrollStaffType['description']
                    ]
                );
            }
        });
    }
}
