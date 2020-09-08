<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetStatus;

/**
 * @class      AssetStatusController
 * @brief      Controlador de los estatus de uso de bienes institucionales
 *
 * Clase que gestiona los estatus de uso de bienes institucionales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetStatusController extends Controller
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
        //$this->middleware('permission:asset.setting.status');
    }

    /**
     * Muestra un listado de los estatus de uso de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetStatus::all()], 200);
    }

    /**
     * Valida y registra un nuevo estatus de uso de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);


        /**
         * Objeto asociado al modelo AssetStatus
         *
         * @var Object $status
         */
        $status = AssetStatus::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $status, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del estatus de uso de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request             $request    Datos de la petición
     * @param     \Modules\Asset\Models\AssetStatus    $status     Datos del status de uso de un bien
     * @return    \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */

    public function update(Request $request, AssetStatus $status)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);

        $status->name = $request->input('name');
        $status->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el estatus de uso de un bien
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Modules\Asset\Models\AssetStatus    $status    Datos del estatus de uso de un bien
     * @return    \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function destroy(AssetStatus $status)
    {
        $status->delete();
        return response()->json(['record' => $status, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de los estatus de uso de los bienes institucionales a implementar en elementos select
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Array    Arreglo con los registros a mostrar
     */
    public function getStatus()
    {
        return template_choices('Modules\Asset\Models\AssetStatus', 'name', '', true);
    }
}
