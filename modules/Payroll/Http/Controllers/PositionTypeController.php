<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PositionType;

/**
 * @class PositionTypeController
 * @brief Controlador de tipos de cargo
 *
 * Clase que gestiona los tipos de cargo
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PositionTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Muesta todos los registros de tipos de cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con la lista de tipos de cargo
     */
    public function index()
    {
        $position_types = PositionType::all();
        return view('payroll::position-types.index', compact('position_types'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con el formulario de registro
     */
    public function create()
    {
        $header = [
            'route' => 'position-types.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::position-types.create-edit', compact('header'));
    }

    /**
     * Guarda un nuevo tipo de cargo en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @return [<b>Route</b>] ruta hacia la vista de listar tipos de cargo
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $position_type = new PositionType;
        $position_type->name  = $request->name;
        $position_type->description = $request->description;
        $position_type->save();
        return redirect()->route('position-types.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Muestra el formulario con los datos a modificar de un tipo de cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $position_type [<b>Modules::Payroll::Models::PositionType</b>] datos del tipo de cargo
     * @return [<b>View</b>] vista con los datos a mostrar en el formulario de edición
     */
    public function edit(PositionType $position_type)
    {
        $header = [
            'route' => ['position-types.update', $position_type], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::position-types.create-edit', compact('position_type','header'));
    }

    /**
     * Hace la actualización de los datos de un tipo de cargo en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] datos de la petición
     * @param $position_type [<b>Modules::Payroll::Models::PositionType</b>] datos del cargo
     * @return [<b>Route</b>] ruta hacia la vista de listar tipos de cargo
     */
    public function update(Request $request, PositionType $position_type)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $position_type->name  = $request->name;
        $position_type->description = $request->description;
        $position_type->save();
        return redirect()->route('position-types.index');
    }

    /**
     * Elimina los datos de un tipo de cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $position_type [<b>Modules::Payroll::Models::PositionType</b>] datos del tipo de cargo
     * @return [<b>Route</<b>] ruta hacia la vista de listar tipos de cargo
     */
    public function destroy(PositionType $position_type)
    {
        $position_type->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}