<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetType;

/**
 * @class AssetTypeController
 * @brief Controlador de tipos de bienes institucionales
 *
 * Clase que gestiona los tipos de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetTypeController extends Controller
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
        $this->middleware('permission:asset.setting.type');
    }
    
    /**
     * Muestra un listado de los tipos de bienes institucionales
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function index()
    {
        return response()->json(['records' => AssetType::all()], 200);
    }

    /**
     * Valida y registra un nuevo tipo de bien institucional
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


        $type = AssetType::create([
            'name' => $request->input('name')
        ]);

        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request       Datos de la petición
     * @param  \Modules\Asset\Models\AssetType  $type   Datos del tipo de bien
     * @return \Illuminate\Http\JsonResponse            Objeto con los registros a mostrar
     */
    
    public function update(Request $request, AssetType $type)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);
 
        $type->name = $request->input('name');
        $type->save();
 
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Asset\Models\AssetType  $type   Datos del tipo de bien
     * @return \Illuminate\Http\JsonResponse            Objeto con los registros a mostrar
     */
    public function destroy(AssetType $type)
    {
        $type->delete();
        return response()->json(['record' => $type, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el listado de tipos de bienes institucionales a implementar en elementos select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return [Array] Arreglo con los registros a mostrar
     */
    public function getTypes()
    {
        return template_choices('Modules\Asset\Models\AssetType', 'name', '', true);
    }
}
