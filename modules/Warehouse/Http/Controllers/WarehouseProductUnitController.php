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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => WarehouseProductUnit::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseProductUnit $unit)
    {
        $unit->delete();
        return response()->json(['record' => $unit, 'message' => 'Success'], 200);
    }

    public function vueList()
    {
        return template_choices('Modules\Warehouse\Models\WarehouseProductUnit','name','',true);
    }
}
