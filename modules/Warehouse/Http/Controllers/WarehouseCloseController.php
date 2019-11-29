<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseClose;
use Modules\Warehouse\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

/**
 * @class WarehouseCloseController
 * @brief Controlador de los cierres de almacén registrados
 *
 * Clase que gestiona los cierres de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseCloseController extends Controller
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
        $this->middleware('permission:warehouse.setting.close');
    }

    /**
     * Muestra un listado de los cierres de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(
            ['records' => WarehouseClose::with('initialUser', 'endUser', 'warehouse')->get()],
            200
        );
    }

    /**
     * Valida y registra un nuevo cierre de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'initial_date'    => ['required'],
            'observations'  => ['required'],
            'warehouse_id' => ['required'],
        ]);

        $warehouse = Warehouse::find($request->warehouse_id);
        $hoy = date("Y-m-d");
        if ($request->initial_date <= $hoy) {
            $warehouse->active = false;
            $warehouse->save();
        }

        $close = WarehouseClose::create([
            'initial_date'    => $request->input('initial_date'),
            'end_date'        => $request->input('end_date'),
            'observations'    => $request->input('observations'),
            'warehouse_id'    => $request->input('warehouse_id'),
            'initial_user_id' => Auth::id(),
        ]);
        if (!is_null($request->end_date)) {
            $close->end_user_id = Auth::id();
            $close->save();
        }
        return response()->json(['record' => $close, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de los cierres de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\WarehouseClose  $close (Datos del cierre de almacén)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, WarehouseClose $close)
    {
        $this->validate($request, [
            'initial_date'  => ['required'],
            'observations'  => ['required'],
            'warehouse_id'  => ['required'],
        ]);

        if ($close->initial_user_id == Auth::id()) {
            $close->initial_date = $request->input('initial_date');
            $close->observations = $request->input('observations');
            $close->warehouse_id = $request->input('warehouse_id');

            if ($close->end_user_id == $close->initial_user_id) {
                $close->end_date = $request->input('end_date');
            }
        } elseif (($close->end_user_id == Auth::id()) ||
            (is_null($close->end_user_id) && ($close->initial_user_id == Auth::id()))) {
            $close->observations = $request->input('observations');
            $close->end_date     = $request->input('end_date');
        }
        $close->save();
 
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un cierre de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Modules\Warehouse\Models\WarehouseClose $close (Datos del Cierre de almacén)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(WarehouseClose $close)
    {
        $close->delete();
        return response()->json(['record' => $close, 'message' => 'Success'], 200);
    }

    /**
     * Finaliza un cierre de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  $id Identificador único del Cierre de Almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function closeWarehouse($id)
    {
        $close = WarehouseClose::find($id);
        if (!is_null($close)) {
            $close->end_user_id = Auth::id();
            $close->end_date = now();
            $close->save();

            $warehouse = Warehouse::find($close->warehouse_id);
            $warehouse->active = true;
            $warehouse->save();
        }
        return response()->json(
            ['records' => WarehouseClose::with('initialUser', 'endUser', 'warehouse')->get()],
            200
        );
    }
}
