<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPosition;

/**
 * @class PositionController
 * @brief Controlador de cargos
 *
 * Clase que gestiona los cargos
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollPositionController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.positions.list', ['only' => 'index']);
        $this->middleware('permission:payroll.positions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.positions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.positions.delete', ['only' => 'destroy']);
    }

    use ValidatesRequests;

    /**
     * Muesta todos los registros de cargos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con la lista de los cargos
     */
    public function index()
    {
        $positions = PayrollPosition::all();
        return view('payroll::positions.index', compact('positions'));
    }

    /**
     * Muestra el formulario para crear un nuevo cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con el formulario de registro
     */
    public function create()
    {
        $header = [
            'route' => 'positions.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::positions.create-edit', compact('header'));
    }

    /**
     * Guarda un nuevo cargo en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @return [<b>Route</b>] ruta hacia la vista de listar cargos
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $position = new PayrollPosition;
        $position->name  = $request->name;
        $position->description = $request->description;
        $position->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('positions.index');
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
     * Muestra el formulario con los datos a modificar de un cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $position [<b>Modules::Payroll::Models::Position</b>] datos del cargo
     * @return [<b>View</b>] vista con los datos a mostrar en el formulario de edición
     */
    public function edit(PayrollPosition $position)
    {
        $header = [
            'route' => ['positions.update', $position], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::positions.create-edit', compact('position','header'));
    }

    /**
     * Hace la actualización de los datos de un cargo en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] datos de la petición
     * @param $position [<b>Modules::Payroll::Models::Position</b>] datos del cargo
     * @return [<b>Route</b>] ruta hacia la vista de listar cargos
     */
    public function update(Request $request, PayrollPosition $position)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $position->name  = $request->name;
        $position->description = $request->description;
        $position->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('positions.index');
    }

    /**
     * Elimina los datos de un cargo
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $position [<b>Modules::Payroll::Models::Position</b>] datos del cargo
     * @return [<b>Route</<b>] ruta hacia la vista de listar cargos
     */
    public function destroy(Request $request, PayrollPosition $position)
    {
        if ($request->ajax())
        {
            $position->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('positions.index');
    }
}
