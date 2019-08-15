<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollSectorType;

/**
 * @class PayrollSectorTypesTableSeeder
 * @brief Inicializar los tipos de sector
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSectorTypesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los tipos de sector
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
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

        DB::transaction(function () use ($payrollSectorTypes) {
            foreach ($payrollSectorTypes as $payrollSectorType) {
                PayrollSectorType::updateOrCreate(
                    ['name' => $payrollSectorType['name']]
                );
            }
        });
    }
}
