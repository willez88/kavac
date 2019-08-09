<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollLanguage;

/**
 * @class PayrollLanguagesTableSeeder
 * @brief Inicializar los idiomas
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollLanguagesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los idiomas
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollLanguages = [
            [
                'name' => 'Español', 'acronym' => 'es'
            ],
            [
                'name' => 'Inglés', 'acronym' => 'en'
            ]
        ];

        DB::transaction(function() use ($payrollLanguages) {
            foreach ($payrollLanguages as $payrollLanguage) {
                PayrollLanguage::updateOrCreate(
                    [
                        'name' => $payrollLanguage['name']
                    ],
                    [
                        'acronym' => $payrollLanguage['acronym']
                    ]
                );
            }
        });
    }
}
