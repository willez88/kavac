<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetCondition;

/**
 * @class AssetConditionController
 * @brief Controlador de la condición física de los bienes institucionales
 *
 * Clase que gestiona la condición física de los bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetConditionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:asset.setting.condition');
    }
    
    /**
     * Muestra un listado de las condiciones físicas de los bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetCondition::all()], 200);
    }

    /**
     * Valida y registra una nueva condición física
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Datos de la petición
     * @return \Illuminate\Http\JsonResponse        Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);


        $condition = AssetCondition::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $condition, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la condición física de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request                 Datos de la petición
     * @param  \Modules\Asset\Models\AssetCondition  $condition   Datos de la condición física
     * @return \Illuminate\Http\JsonResponse                      Objeto con los registros a mostrar
     */
    
    public function update(Request $request, AssetCondition $condition)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);
 
        $condition->name = $request->input('name');
        $condition->save();
 
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la condición física de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetCondition  $condition   Datos de la condición física
     * @return \Illuminate\Http\JsonResponse                      Objeto con los registros a mostrar
     */
    public function destroy(AssetCondition $condition)
    {
        $condition->delete();
        return response()->json(['record' => $condition, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de las condiciones físicas de los bienes institucionales a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return [Array] Arreglo con los registros a mostrar
     */
    public function getConditions()
    {
        return template_choices('Modules\Asset\Models\AssetCondition', 'name', '', true);
    }
}
