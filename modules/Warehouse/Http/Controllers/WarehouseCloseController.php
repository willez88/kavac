<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseClose;
use Illuminate\Support\Facades\Auth;

/**
 * @class WarehouseCloseController
 * @brief Controlador de los Cierres de Almacén de una Institución
 * 
 * Clase que gestiona los Cierres de Almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseCloseController extends Controller
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
        $this->middleware('permission:warehouse.setting.close');
    }

    /**
     * Muestra un listado de los Cierres de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => WarehouseClose::with('start_user','end_user','warehouse')->get()], 200);
    }

    /**
     * Valida y Registra un nuevo Cierre de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date_init' => 'required',
            'observation' => 'required',
            'warehouse_id' => 'required',
        ]);

        $close = WarehouseClose::create([
            'date_init' => $request->input('date_init'),
            'date_end' => $request->input('date_end'),
            'observation' => $request->input('observation'),
            'warehouse_id' => $request->input('warehouse_id'),
            'user_init' => Auth::id(),            
        ]);
        if(!is_null($request->date_end)){
            $close->user_end =Auth::id();
            $close->save();
        }
        return response()->json(['record' => $close, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de los Cierres de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\WarehouseClose  $close (Datos del cierre de almacén)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request,WarehouseClose $close)
    {
        $this->validate($request, [
            'date_init' => 'required',
            'observation' => 'required',
            'warehouse_id' => 'required',
        ]);

        if($close->user_init == Auth::id())
        {
            $close->date_init = $request->input('date_init');
            $close->observation = $request->input('observation');
            $close->warehouse_id = $request->input('warehouse_id');
            if($close->user_end == $close->user_init)
                $close->date_end = $request->input('date_end');
        }
        else if(($close->user_end == Auth::id())||is_null($close->user_end))
        {
            $close->observation = $request->input('observation');
            $close->date_end = $request->input('date_end');
        }
        else
            return response()->json(['message' => 'No dispone los permisos'], 200);
        
        $close->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina un Cierre de Almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
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
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  $id Identificador único del Cierre de Almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */

    public function close_warehouse($id)
    {        
        $close = WarehouseClose::findorfail($id);
        $close->user_end = Auth::id();
        $close->date_end = now();
        $close->save();
        return response()->json(['records' => WarehouseClose::with('start_user','end_user','warehouse')->get()], 200);
    }
}
