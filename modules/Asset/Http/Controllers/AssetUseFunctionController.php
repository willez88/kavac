<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetUseFunction;

/**
 * @class AssetUseFunctionController
 * @brief Controlador de las funciones de uso de los bienes institucionales
 *
 * Clase que gestiona las funciones de uso de los bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetUseFunctionController extends Controller
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
        //$this->middleware('permission:asset.setting.use-function');
    }
    
    /**
     * Muestra un listado de las funciones de uso de los bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetUseFunction::all()], 200);
    }

    /**
     * Valida y registra una nueva funcion de uso
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


        $function = AssetUseFunction::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $function, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la función de uso de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request                  Datos de la petición
     * @param  \Modules\Asset\Models\AssetUseFunction  $function   Datos de la función de uso de un bien
     * @return \Illuminate\Http\JsonResponse                       Objeto con los registros a mostrar
     */
    
    public function update(Request $request, $id)
    {
        $function = AssetUseFunction::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);
        
        if ($function) {
            $function->name = $request->input('name');
            $function->save();
        }
 
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina la función de uso de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetUseFunction  $function   Datos de la función de uso de un bien
     * @return \Illuminate\Http\JsonResponse                       Objeto con los registros a mostrar
     */
    public function destroy($id)
    {
        $function = AssetUseFunction::find($id);
        if ($function) {
            $function->delete();
        }
        return response()->json(['record' => $function, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de las funciones de uso registradas a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return [Array] Arreglo con los registros a mostrar
     */
    public function getUseFunctions()
    {
        return template_choices('Modules\Asset\Models\AssetUseFunction', 'name', '', true);
    }
}
