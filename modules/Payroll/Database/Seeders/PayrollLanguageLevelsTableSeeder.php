<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollLanguageLevel;

/**
 * @class PayrollLanguageLevelsTableSeeder
 * @brief Inicializar los niveles de idioma
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollLanguageLevelsTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los niveles de idioma
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollLanguageLevels = [
            [
                'name' => 'Básico'
            ],
            [
                'name' => 'Intermedio'
            ],
            [
                'name' => 'Avanzado'
            ],
            [
                'name' => 'Nativo'
            ]
        ];

        DB::transaction(function () use ($payrollLanguageLevels) {
            foreach ($payrollLanguageLevels as $payrollLanguageLevel) {
                PayrollLanguageLevel::updateOrCreate(
                    ['name' => $payrollLanguageLevel['name']]
                );
            }
        });
    }
}
