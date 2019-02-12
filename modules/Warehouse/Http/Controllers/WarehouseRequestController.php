<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseRequest;
use Modules\Warehouse\Models\Warehouse;


/**
 * @class WarehouseRequestController
 * @brief Controlador de Solicitudes de Almacén
 * 
 * Clase que gestiona las Solicitudes de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseRequestController extends Controller
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
        $this->middleware('permission:warehouse.request.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.request.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.request.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.request.delete', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $warehouse_requests = WarehouseRequest::all();
        return view('warehouse::requests.list', compact('warehouse_requests'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'warehouse.request.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        return view('warehouse::requests.create', compact('header'));
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
        return view('warehouse::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(WarehouseRequest $request)
    {
        $header = [
            'route' => 'warehouse.request.update', 'method' => 'PUT', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        return view('warehouse::requests.create', compact('header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseRequest $request)
    {
        $request->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
