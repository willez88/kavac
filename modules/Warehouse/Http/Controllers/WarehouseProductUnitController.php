<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseProductUnit;

/**
 * @class WarehouseProductUnitController
 * @brief Controlador de las Unidades Métricas de los Productos de Almacén
 * 
 * Clase que gestiona los datos de las Unidades Métricas de los Productos de Almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseProductUnitController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.setting.unit');
    }

    /**
     * Muestra un listado de las Unidades Métricas Registradas
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => WarehouseProductUnit::all()], 200);
    }

    /**
     * Valida y Registra una nueva Unidad Métrica
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:20',
            'abbreviation' => 'required|max:4',
        ]);

        $unit = WarehouseProductUnit::create([
            'name' => $request->input('name'),
            'abbreviation' => $request->input('abbreviation'),
        ]);

        return response()->json(['record' => $unit, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de las Unidades Métricas Registradas
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\WarehouseProductUnit $unit (Registro a ser actualizado)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, WarehouseProductUnit $unit)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'abbreviation' => 'required|max:4'
        ]);
 
        $unit->name = $request->input('name');
        $unit->abbreviation = $request->input('abbreviation');
        $unit->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina una Unidad Métrica Registrada
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Warehouse\Models\WarehouseProductUnit $unit (Registro a ser eliminado)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(WarehouseProductUnit $unit)
    {
        $unit->delete();
        return response()->json(['record' => $unit, 'message' => 'Success'], 200);
    }

    /**
     * Muestra una lista de Unidades Métricas para elementos del tipo select
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Array con los registros a mostrar
     */

    public function vueList()
    {
        return template_choices('Modules\Warehouse\Models\WarehouseProductUnit','name','',true);
    }
}
