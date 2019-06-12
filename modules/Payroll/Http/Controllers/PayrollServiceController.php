<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @class PayrollServiceController
 * @brief Controlador de Servicios del Módulo de Nómina
 * 
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollServiceController extends Controller
{
    public function getStaffs(){
        return template_choices('Modules\Payroll\Models\PayrollStaff',['id_number', '-', 'full_name'], '',true);
    }
    
    public function getAssignmentTypes(){
        return template_choices('Modules\Payroll\Models\PayrollAssignmentType','name','',true);
    }

    public function getPositionTypes(){
        return template_choices('Modules\Payroll\Models\PayrollPositionType','name','',true);
    }

    public function getPositions(){
        return template_choices('Modules\Payroll\Models\PayrollPosition','name','',true);
    }

    public function getInstructionDegrees(){
        return template_choices('Modules\Payroll\Models\PayrollInstructionDegree','name','',true);
    }
    
    public function create()
    {
        return view('payroll::salary-simulator.create');
    }
}
