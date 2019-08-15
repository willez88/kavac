<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollContractType;

/**
 * @class PayrollContractTypesTableSeeder
 * @brief Inicializar los tipos de contrato
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollContractTypesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los tipos de contrato
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
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

        DB::transaction(function () use ($payrollContractTypes) {
            foreach ($payrollContractTypes as $payrollContractType) {
                PayrollContractType::updateOrCreate(
                    ['name' => $payrollContractType['name']]
                );
            }
        });
    }
}
