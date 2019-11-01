<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Payroll\Models\PayrollSalaryAssignmentType;

/**
 * @class PayrollSalaryAssignmentTypesTableSeeder
 * @brief Registrar información por defecto de las asignaciones salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryAssignmentTypesTableSeeder extends Seeder
{
    /**
     * Método que ejecuta el seeder
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $assignment_type = [
            ['name' => 'Primas'],
            ['name' => 'Bonificaciones'],
            ['name' => 'Deducciones'],
            ['name' => 'Aportes patronales'],
            
        ];
   
        foreach ($assignment_type as $type) {
            PayrollSalaryAssignmentType::updateOrCreate(
                ['name' => $type['name']]
            );
        }
    }
}
