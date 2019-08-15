<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Payroll\Models\PayrollInstructionDegree;

/**
 * @class PayrollInstructionDegreesTableSeeder
 * @brief Inicializar los grados de instruccíón
 *
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollInstructionDegreesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores de los grados de instrucción
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payrollInstructionDegrees = [
            [
                'name' => 'Primaria', 'description' => null
            ],
            [
                'name' => 'Bachillerato', 'description' => null
            ],
            [
                'name' => 'Técnico Medio', 'description' => null
            ],
            [
                'name' => 'TSU Universitario', 'description' => null
            ],
            [
                'name' => 'Universitario Pregrado', 'description' => null
            ],
            [
                'name' => 'Especialización', 'description' => null
            ],
            [
                'name' => 'Maestría', 'description' => null
            ],
            [
                'name' => 'Doctorado', 'description' => null
            ]
        ];

        DB::transaction(function () use ($payrollInstructionDegrees) {
            foreach ($payrollInstructionDegrees as $payrollInstructionDegree) {
                PayrollInstructionDegree::updateOrCreate(
                    ['name' => $payrollInstructionDegree['name']],
                    [
                        'description' => $payrollInstructionDegree['description']
                    ]
                );
            }
        });
    }
}
