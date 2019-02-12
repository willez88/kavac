<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseReception;
use Modules\Warehouse\Models\Warehouse;


/**
 * @class WarehouseReceptionController
 * @brief Controlador de Recepciones de Almacén
 * 
 * Clase que gestiona las Recepciones de los artículos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseReceptionController extends Controller
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
        $this->middleware('permission:warehouse.reception.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.reception.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.reception.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.reception.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $receptions = WarehouseReception::all();
        return view('warehouse::receptions.list', compact('receptions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'warehouse.reception.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        return view('warehouse::receptions.create',compact('header'));
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
    public function edit()
    {
        return view('warehouse::edit');
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
    public function destroy()
    {
    }
}
