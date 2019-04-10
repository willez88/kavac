<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseMovement;
use Modules\Warehouse\Models\Warehouse;


/**
 * @class WarehouseMovementController
 * @brief Controlador de Movimientos de productos de Almacén
 * 
 * Clase que gestiona los movimientos de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseMovementController extends Controller
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
        $this->middleware('permission:warehouse.movement.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.movement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.movement.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.movement.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $movements = WarehouseMovement::with('start','finish')->get();
        return view('warehouse::movements.list', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('warehouse::movements.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //return view('warehouse::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //return view('warehouse::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $warehouse_movement = WarehouseMovement::find($id);
        $warehouse_movement->delete();
        return response()->json(['record' => $warehouse_movement,
                                 'message' => 'Success'],200);
    }
}
