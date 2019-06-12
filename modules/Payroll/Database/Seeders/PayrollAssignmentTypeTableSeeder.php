<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Payroll\Models\PayrollAssignmentType;

/**
 * @class PayrollAssignmentType
 * @brief Inicializar tipos de asignaciones de nómina
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollAssignmentTypeTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de tipos de bien
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
            PayrollAssignmentType::updateOrCreate(
                ['name' => $type['name']]
            );
        }
    }
}
