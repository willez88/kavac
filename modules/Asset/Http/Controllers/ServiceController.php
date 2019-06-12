<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @class ServiceController
 * @brief Controlador de Servicios del Módulo de Bienes
 * 
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class ServiceController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct() {
        $this->data[0] = [
            'id' => 0,
            'text' => 'Seleccione...'
        ];
    }

    public function GetRequestTypes()
    {
        $this->data[1] = [
            'id' => 1,
            'text' => 'AVERIADO'
        ];
        $this->data[2] = [
            'id' => 2,
            'text' => 'PERDIDO'
        ];
        

        return response()->json($this->data);
        
    }

    public function getStaffs(){
        return template_choices('Modules\Payroll\Models\PayrollStaff',['id_number', '-', 'full_name'], '',true);
    }
    public function getTypePositions(){
        return template_choices('Modules\Payroll\Models\PayrollPositionType','name','',true);
    }
    public function getPositions(){
        return template_choices('Modules\Payroll\Models\PayrollPosition','name','',true);
    }
    public function getPurchases(){
        return template_choices('Modules\Asset\Models\AssetPurchase','name','',true);
    }

    public function getConditions(){
        return template_choices('Modules\Asset\Models\AssetCondition','name','',true);
    }

    public function getStatus(){
        return template_choices('Modules\Asset\Models\AssetStatus','name','',true);
    }

    public function getUses(){
        return template_choices('Modules\Asset\Models\AssetUse','name','',true);
    }

    public function getMotives(){
        return template_choices('Modules\Asset\Models\AssetMotiveDisincorporation','name','',true);
    }
}
