<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\StaffType;

/**
 * @class StaffTypeController
 * @brief Controlador de tipos de personal
 *
 * Clase que gestiona el tipo de personal
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class StaffTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Muesta todos los registros de tipo de personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con la lista del tipo de personal
     */
    public function index()
    {
        $staff_types = StaffType::all();
        //error_log($staff_types);
        return view('payroll::staff-types.index', compact('staff_types'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con el formulario de registro
     */
    public function create()
    {
        $header_staff_type = [
            'route' => 'staff-types.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-types.create', compact('header_staff_type'));
    }

    /**
     * Guarda un nuevo tipo de personal en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @return [<b>Route</b>] ruta hacia la vista de listar el tipo de personal
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $staff_type = new StaffType;
        $staff_type->name  = $request->name;
        $staff_type->description = $request->description;
        $staff_type->save();
        return redirect()->route('staff-types.index');
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
     * Muestra el formulario con los datos a modificar de un tipo de personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $staff_type [<b>Modules::Payroll::Models::StaffType</b>] datos del tipo de personal
     * @return [<b>View</b>] vista con los datos a mostrar en el formulario de edición
     */
    public function edit(StaffType $staff_type)
    {
        $model_staff_type = $staff_type;
        $header_staff_type = [
            'route' => ['staff-types.update', $staff_type], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-types.edit', compact('model_staff_type','header_staff_type'));
    }

    /**
     * Hace la actualización de los datos del tipo de personal en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] datos de la petición
     * @param $staff_type [<b>Modules::Payroll::Models::StaffType</b>] datos del tipo de personal
     * @return [<b>Route</b>] ruta hacia la vista de listar cargos
     */
    public function update(Request $request, StaffType $staff_type)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $staff_type->name  = $request->name;
        $staff_type->description = $request->description;
        $staff_type->save();
        return redirect()->route('staff-types.index');
    }

    /**
     * Elimina los datos de un tipo de personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $staff_type [<b>Modules::Payroll::Models::StaffType</b>] datos del tipo de personal
     * @return [<b>Route</<b>] ruta hacia la vista de listar cargos
     */
    public function destroy(StaffType $staff_type)
    {
        $staff_type->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
