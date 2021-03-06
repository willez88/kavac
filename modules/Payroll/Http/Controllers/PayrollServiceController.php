<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * @class PayrollServiceController
 * @brief Controlador de Servicios del Módulo de Nómina
 *
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */

class PayrollServiceController extends Controller
{
    public function getStaffs()
    {
        return template_choices('Modules\Payroll\Models\PayrollStaff', ['id_number','-','full_name'], '', true);
    }

    public function getInstructionDegrees()
    {
        return template_choices('Modules\Payroll\Models\PayrollInstructionDegree', 'name', '', true);
    }
}
