<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Institution;
use App\Models\Department;
use Modules\Payroll\Models\PayrollPosition;
use Modules\Payroll\Models\PayrollStaff;
use Modules\Budget\Models\BudgetProject;

/**
 * @class BudgetProjectController
 * @brief Controlador de Proyectos
 * 
 * Clase que gestiona los Proyectos
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetProjectController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.project.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.project.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.project.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.project.delete', ['only' => 'destroy']);
    }
    
    /**
     * Muestra un listado de proyectos
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function index()
    {
        return view('budget::index');
    }

    /**
     * Muestra el formulario para crear un proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function create()
    {
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => 'budget.projects.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $institutions = template_choices(Institution::class, ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de departamentos a representar en la plantilla para su selección */
        $departments = template_choices(Department::class, ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de cargos a representar en la plantilla para su selección */
        $positions = template_choices(PayrollPosition::class, 'name');
        /** @var array Arreglo de opciones de personal a representar en la plantilla para su selección */
        $staffs = template_choices(PayrollStaff::class, ['id_number', '-', 'full_name'], ['active' => true]);

        return view('budget::projects.create-edit-form', compact(
            'header', 'institutions', 'departments', 'positions', 'staffs'
        ));
    }

    /**
     * Guarda información del nuevo proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'institution_id' => 'required',
            'department_id' => 'required',
            'payroll_position_id' => 'required',
            'payroll_staff_id' => 'required',
            'code' => 'required',
            'onapre_code' => 'required',
            'name' => 'required',
        ]);

        /**
         * Registra el nuevo proyecto
         */
        BudgetProject::create([
            'name' => $request->name,
            'code' => $request->code,
            'onapre_code' => $request->onapre_code,
            'active' => ($request->active!==null),
            'department_id' => $request->department_id,
            'payroll_position_id' => $request->payroll_position_id,
            'payroll_staff_id' => $request->payroll_staff_id
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Muestra información de un proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador del proyecto a mostrar
     * @return Response
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Muestra el formulario para editar un proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador del proyecto a modificar
     * @return Response
     */
    public function edit($id)
    {
        /** @var object Objeto con información del proyecto a modificar */
        $budgetProject = BudgetProject::find($id);
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => ['budget.projects.update', $budgetProject->id], 
            'method' => 'PUT', 
            'role' => 'form'
        ];
        /** @var object Objeto con datos del modelo a modificar */
        $model = $budgetProject;

        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $institutions = template_choices(Institution::class, ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de departamentos a representar en la plantilla para su selección */
        $departments = template_choices(Department::class, ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de cargos a representar en la plantilla para su selección */
        $positions = template_choices(PayrollPosition::class, 'name');
        /** @var array Arreglo de opciones de personal a representar en la plantilla para su selección */
        $staffs = template_choices(PayrollStaff::class, ['id_number', '-', 'full_name'], ['active' => true]);

        return view('budget::projects.create-edit-form', compact(
            'header', 'model', 'institutions', 'departments', 'positions', 'staffs'
        ));
    }

    /**
     * Actualiza la información de un proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id Identificador del proyecto a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'institution_id' => 'required',
            'department_id' => 'required',
            'payroll_position_id' => 'required',
            'payroll_staff_id' => 'required',
            'code' => 'required',
            'onapre_code' => 'required',
            'name' => 'required',
        ]);

        /** @var object Objeto con información del proyecto a modificar */
        $budgetProject = BudgetProject::find($id);
        $budgetProject->fill($request->all());
        /** @var boolean Establece si el proyecto esta o no activo */
        $budgetProject->active = $request->active ?? false;
        $budgetProject->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Elimina un proyecto específico
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador del proyecto a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con información del proyecto a eliminar */
        $budgetProject = BudgetProject::find($id);

        if ($budgetProject) {
            $budgetProject->delete();
        }
        
        return response()->json(['record' => $budgetProject, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene listado de registros
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  [boolean] $active Filtrar por estatus del registro, valores permitidos true o false, este parámetro es opcional.
     * @return \Illuminate\Http\JsonResponse
     */
    public function vueList($active = null)
    {
        /** @var object Objeto con información de los proyectos registrados */
        $budgetProjects = ($active !== null) 
                          ? BudgetProject::where('active', $active)->with('payroll_staff')->get() 
                          : BudgetProject::with('payroll_staff')->get();
        return response()->json(['records' => $budgetProjects], 200);
    }

    /**
     * Obtiene los proyectos registrados
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador del proyecto a buscar, este parámetro es opcional
     * @return JSON        JSON con los datos de los proyectos
     */
    public function getProjects($id = null)
    {
        return response()->json(template_choices(
            BudgetProject::class, ['code', '-', 'name'], ($id) ? ['id' => $id] : [], true
        ));
    }
}
