<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Payroll\Models\PayrollSalaryAssignmentType;

/**
 * @class PayrollSalaryAssignmentType
 * @brief Inicializar tipos de asignaciones salariales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollSalaryAssignmentTypeTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de los tipos de asignaciones salariales
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
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
