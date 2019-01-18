<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollStaffClassification;

/**
 * @class StaffClassificationController
 * @brief Controlador de clasificación del personal
 *
 * Clase que gestiona las clasificaciones del personal
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollStaffClassificationController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.staff.classifications.index', ['only' => 'index']);
        $this->middleware('permission:payroll.staff.classifications.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.staff.classifications.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.staff.classifications.delete', ['only' => 'destroy']);
    }

    use ValidatesRequests;

    /**
     * Muesta todos los registros de clasificaciones del personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con la lista de las clasificaciones del personal
     */
    public function index()
    {
        $staff_classifications = PayrollStaffClassification::all();
        return view('payroll::staff-classifications.index', compact('staff_classifications'));
    }

    /**
     * Muestra el formulario para crear una nueva clasificación del personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>View</b>] vista con el formulario de registro
     */
    public function create()
    {
        $header = [
            'route' => 'staff-classifications.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-classifications.create-edit', compact('header'));
    }

    /**
     * Guarda una nueva clasificación del personal en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] Datos de la petición
     * @return [<b>Route</b>] ruta hacia la vista de listar clasificaciones del personal
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $staff_classification = new PayrollStaffClassification;
        $staff_classification->name  = $request->name;
        $staff_classification->description = $request->description;
        $staff_classification->save();
        return redirect()->route('staff-classifications.index');
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
     * Muestra el formulario con los datos a modificar de una clasificación del personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $staff_classification [<b>Modules::Payroll::Models::StaffClassification</b>] datos de la clasificación del personal
     * @return [<b>View</b>] vista con los datos a mostrar en el formulario de edición
     */
    public function edit(PayrollStaffClassification $staff_classification)
    {
        $header = [
            'route' => ['staff-classifications.update', $staff_classification], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-classifications.create-edit', compact('staff_classification','header'));
    }

    /**
     * Hace la actualización de los datos de una clasificación del personal en la base de datos
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $request [<b>Illuminate::Http::Request</b>] datos de la petición
     * @param $staff_classification [<b>Modules::Payroll::Models::StaffClassification</b>] datos de la clasificación del personal
     * @return [<b>Route</b>] ruta hacia la vista de listar las clasificaciones del personal
     */
    public function update(Request $request, PayrollStaffClassification $staff_classification)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required|max:200'
        ]);
        $staff_classification->name  = $request->name;
        $staff_classification->description = $request->description;
        $staff_classification->save();
        return redirect()->route('staff-classifications.index');
    }

    /**
     * Elimina los datos de una clasificación del personal
     *
     * @author William Páez (wpaez at cenditel.gob.ve)
     * @param $staff_classification [<b>Modules::Payroll::Models::StaffClassification</b>] datos de la clasificación del personal
     * @return [<b>Route</<b>] ruta hacia la vista de listar las clasificaciones del personal
     */
    public function destroy(Request $request, PayrollStaffClassification $staff_classification)
    {
        if ($request->ajax()) {
            $staff_classification->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('staff-types.index');
    }
}
