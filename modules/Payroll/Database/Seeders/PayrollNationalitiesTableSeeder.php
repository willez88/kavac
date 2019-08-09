<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollNationality;
use Modules\Payroll\Models\Country as BaseCountry;

/**
 * @class PayrollNationalitiesTableSeeder
 * @brief Inicializar las nacionalidades
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollNationalitiesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de las nacionalidades
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollNationalities = [
            [
                'name' => 'Venezolano(a)',
                'country_id' => BaseCountry::where('name', 'Venezuela')->first()
            ],
        ];

        DB::transaction(function() use ($payrollNationalities) {
            foreach ($payrollNationalities as $payrollNationality) {
                if (!is_null($payrollNationality['country_id'])) {
                    PayrollNationality::updateOrCreate(
                        [
                            'country_id' => $payrollNationality['country_id']->id
                        ],
                        [
                            'name' => $payrollNationality['name']
                        ]
                    );
                }
            }
        });
    }
}
