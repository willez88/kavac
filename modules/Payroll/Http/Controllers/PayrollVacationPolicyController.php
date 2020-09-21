<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @class      PayrollVacationPolicyController
 * @brief      Controlador de políticas vacacionales
 *
 * Clase que gestiona las políticas vacacionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollVacationPolicyController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.vacation-policies.list',   ['only' => 'index']);
        //$this->middleware('permission:payroll.vacation-policies.create', ['only' => 'store']);
        //$this->middleware('permission:payroll.vacation-policies.edit',   ['only' => 'update']);
        //$this->middleware('permission:payroll.vacation-policies.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
        ];
    }

    /**
     * Muestra un listado de las políticas vacacionales registradas
     *
     * @method    index
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => []], 200);
    }

    /**
     * Valida y registra una nueva política vacacional
     *
     * @method    store
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);
        return response()->json(['record' => null, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una política vacacional
     *
     * @method    update
     *
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @param     Integer                          $id         Identificador único de la política vacacional
     *
     * @return    \Illuminate\Http\JsonResponse                Objeto con los registros a mostrar
     */
    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina una política vacacional
     *
     * @method    destroy
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     Integer                          $id    Identificador único de la política vacacional a eliminar
     *
     * @return    Renderable
     */
    public function destroy($id)
    {
    }
}
