<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\Institution;
use Modules\Budget\Models\Department;
use Modules\Budget\Models\BudgetCentralizedAction;
use Module;

/**
 * @class BudgetCentralizedActionController
 * @brief Controlador de Acciones Centralizadas
 *
 * Clase que gestiona las Acciones Centralizadas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetCentralizedActionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.centralizedaction.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.centralizedaction.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.centralizedaction.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.centralizedaction.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de acciones centralizadas
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Renderable
     */
    public function index()
    {
        return view('budget::index');
    }

    /**
     * Muestra el formulario para la creación de acciones centralizadas
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Renderable
     */
    public function create()
    {
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => 'budget.centralized-actions.store',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $institutions = template_choices(Institution::class, ['acronym'], ['active' => true]);
        /** @var array Arreglo de opciones de departamentos a representar en la plantilla para su selección */
        $departments = template_choices(Department::class, ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de cargos a representar en la plantilla para su selección */
        $positions = (Module::has('Payroll') && Module::isEnabled('Payroll'))
                     ? template_choices(
                         \Modules\Payroll\Models\PayrollPosition::class,
                         'name',
                         ['relationship' => 'payrollEmployments', 'where' => ['active' => true]]
                     )
                     : [];
        /** @var array Arreglo de opciones de personal a representar en la plantilla para su selección */
        $staffs = (Module::has('Payroll') && Module::isEnabled('Payroll'))
                  ? template_choices(
                      \Modules\Payroll\Models\PayrollStaff::class,
                      ['id_number', '-', 'full_name'],
                      ['relationship' => 'payrollEmployment', 'where' => ['active' => true]]
                  )
                  : [];
        return view('budget::centralized_actions.create-edit-form', compact(
            'header',
            'institutions',
            'departments',
            'positions',
            'staffs'
        ));
    }

    /**
     * Registra información de la acción centralizada
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $rules = [
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'code' => ['required'],
            'custom_date' => ['required', 'date'],
            'name' => ['required'],
        ];

        if (Module::has('Payroll') && Module::isEnabled('Payroll')) {
            $rules['payroll_position_id'] = 'required';
            $rules['payroll_staff_id'] = 'required';
        }

        $this->validate($request, $rules);

        /**
         * Registra el nuevo proyecto
         */
        BudgetCentralizedAction::create([
            'name' => $request->name,
            'code' => $request->code,
            'custom_date' => $request->custom_date,
            'active' => ($request->active!==null),
            'department_id' => $request->department_id,
            'payroll_position_id' => (!is_null($request->payroll_position_id))
                                     ? $request->payroll_position_id : null,
            'payroll_staff_id' => (!is_null($request->payroll_staff_id))
                                  ? $request->payroll_staff_id : null
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Muestra información de una acción centralizada
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción centralizada a mostrar
     * @return Renderable
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Muestra el formulario de edición de acciones centralizadas
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción centralizada a modificar
     * @return Renderable
     */
    public function edit($id)
    {
        /** @var object Objeto con información de la acción centralizada a modificar */
        $budgetCentralizedAction = BudgetCentralizedAction::find($id);

        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => ['budget.centralized-actions.update', $budgetCentralizedAction->id],
            'method' => 'PUT',
            'role' => 'form'
        ];
        /** @var object Objeto con datos del modelo a modificar */
        $model = $budgetCentralizedAction;

        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $institutions = template_choices('App\Models\Institution', ['acronym'], ['active' => true]);
        /** @var array Arreglo de opciones de departamentos a representar en la plantilla para su selección */
        $departments = template_choices('App\Models\Department', ['acronym', '-', 'name'], ['active' => true]);
        /** @var array Arreglo de opciones de cargos a representar en la plantilla para su selección */
        $positions = (Module::has('Payroll') && Module::isEnabled('Payroll'))
                     ? template_choices(
                         \Modules\Payroll\Models\PayrollPosition::class,
                         'name',
                         ['relationship' => 'payrollEmployments', 'where' => ['active' => true]]
                     )
                     : [];
        /** @var array Arreglo de opciones de personal a representar en la plantilla para su selección */
        $staffs = (Module::has('Payroll') && Module::isEnabled('Payroll'))
                  ? template_choices(
                      \Modules\Payroll\Models\PayrollStaff::class,
                      ['id_number', '-', 'full_name'],
                      ['relationship' => 'payrollEmployment', 'where' => ['active' => true]]
                  )
                  : [];

        return view('budget::centralized_actions.create-edit-form', compact(
            'header',
            'model',
            'institutions',
            'departments',
            'positions',
            'staffs'
        ));
    }

    /**
     * Actualiza información de una acción centralizada
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request
     * @param  integer $id      Identificador de la acción centralizada a modificar
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'institution_id' => ['required'],
            'department_id' => ['required'],
            'code' => ['required'],
            'custom_date' => ['required', 'date'],
            'name' => ['required'],
        ];

        if (Module::has('Payroll') && Module::isEnabled('Payroll')) {
            $rules['payroll_position_id'] = 'required';
            $rules['payroll_staff_id'] = 'required';
        }

        $this->validate($request, $rules);

        /** @var object Objeto con información de la acción centralizada a modificar */
        $budgetCentralizedAction = BudgetCentralizedAction::find($id);
        $budgetCentralizedAction->fill($request->all());
        $budgetCentralizedAction->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Elimina una acción centralizada
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id      Identificador de la acción centralizada a eliminar
     * @return Renderable
     */
    public function destroy($id)
    {
        /** @var object Objeto con información de la acción centralizada a eliminar */
        $budgetCentralizedAction = BudgetCentralizedAction::find($id);

        if ($budgetCentralizedAction) {
            $budgetCentralizedAction->delete();
        }

        return response()->json(['record' => $budgetCentralizedAction, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene listado de registros
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  [boolean] $active Filtrar por estatus del registro, valores permitidos true o false,
     *                           este parámetro es opcional.
     * @return \Illuminate\Http\JsonResponse
     */
    public function vueList($active = null)
    {
        /** @var object Objeto con información de las acciones centralizadas */
        $centralizedActions = ($active !== null)
                              ? BudgetCentralizedAction::where('active', $active)->with('payrollStaff')->get()
                              : BudgetCentralizedAction::with('payrollStaff')->get();

        return response()->json(['records' => $centralizedActions], 200);
    }

    /**
     * Obtiene las acciones centralizadas registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción centralizada a buscar, este parámetro es opcional
     * @return JSON        JSON con los datos de las acciones centralizadas
     */
    public function getCentralizedActions($id = null)
    {
        return response()->json(template_choices(
            BudgetCentralizedAction::class,
            ['code', '-', 'name'],
            ($id) ? ['id' => $id] : [],
            true
        ));
    }
}
