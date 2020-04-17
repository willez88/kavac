<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollConcept;

/**
 * @class      PayrollConceptController
 * @brief      Controlador de conceptos
 *
 * Clase que gestiona los conceptos
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollConceptController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.setting.concept');
    }
    
    /**
     * Muestra un listado de los conceptos registradas (activos e inactivos)
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => PayrollConcept::all()], 200);
    }

    /**
     * Valida y registra un nuevo concepto
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request     $request    Datos de la petición
     * @return    \Illuminate\Http\Response    JSON con los registros a mostrar
     */
    public function store(Request $request)
    {
    }

    /**
     * Actualiza la información de una asignación salarial
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function update(Request $request)
    {
    }

    /**
     * Elimina un concepto
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     Integer $id                      Identificador único del concepto a eliminar
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
    }
}
