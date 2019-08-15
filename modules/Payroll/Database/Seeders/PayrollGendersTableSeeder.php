<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollGender;

/**
 * @class PayrollGendersTableSeeder
 * @brief Inicializar los géneros
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollGendersTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los géneros
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollGenders = [
            [
                'name' => 'Masculino'
            ],
            [
                'name' => 'Femenino'
            ]
        ];

        DB::transaction(function () use ($payrollGenders) {
            foreach ($payrollGenders as $payrollGender) {
                PayrollGender::updateOrCreate(
                    ['name' => $payrollGender['name']]
                );
            }
        });
    }
}
