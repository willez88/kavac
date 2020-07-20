<?php

/** Eliminar */
namespace Modules\Asset\Http\Controllers;

use Illuminate\Routing\Controller;
use Module;

/**
 * @class ServiceController
 * @brief Controlador de Servicios del Módulo de Bienes
 *
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetServiceController extends Controller
{
    public function getPayrollStaffs()
    {
        return (Module::has('Payroll'))?
            template_choices('Modules\Payroll\Models\PayrollStaff', ['id_number', '-', 'full_name'], '', true) : [];
    }
    public function getPayrollPositionTypes()
    {
        return (Module::has('Payroll'))?
            template_choices('Modules\Payroll\Models\PayrollPositionType', 'name', '', true) : [];
    }
    public function getPayrollPositions()
    {
        return (Module::has('Payroll'))?
            template_choices('Modules\Payroll\Models\PayrollPosition', 'name', '', true) : [];
    }
}
