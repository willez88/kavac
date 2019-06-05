<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Crypt;

use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetCentralizedAction;
use Modules\Budget\Models\BudgetSpecificAction;
use Modules\Budget\Models\BudgetSubSpecificFormulation;

/**
 * @class BudgetSpecificActionController
 * @brief Controlador de Acciones Específicas
 * 
 * Clase que gestiona las Acciones Específicas
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetSpecificActionController extends Controller
{
    use ValidatesRequests;

    public $projects;
    public $centralized_actions;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.specificaction.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.specificaction.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.specificaction.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.specificaction.delete', ['only' => 'destroy']);

        /** @var array Arreglo de opciones de proyectos a representar en la plantilla para su selección */
        $this->projects = template_choices(BudgetProject::class, ['code', '-', 'name'], ['active' => true]);

        /** @var array Arreglo de opciones de acciones centralizadas a representar en la plantilla para su selección */
        $this->centralized_actions = template_choices(
            BudgetCentralizedAction::class, ['code', '-', 'name'], ['active' => true]
        );
    }

    /**
     * Muestra un listado de acciones específicas
     * 
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function index()
    {
        return view('budget::index');
    }

    /**
     * Muestra el formulario para crear una acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function create()
    {
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => 'budget.specific-actions.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];

        /** @var array Arreglo de opciones de proyectos a representar en la plantilla para su selección */
        $projects = $this->projects;
        /** @var array Arreglo de opciones de acciones centralizadas a representar en la plantilla para su selección */
        $centralized_actions = $this->centralized_actions;

        return view('budget::specific_actions.create-edit-form', compact(
            'header', 'projects', 'centralized_actions'
        ));
    }

    /**
     * Registra información de la acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'project_centralized_action' => 'required',
            'project_id' => 'required_if:project_centralized_action,project',
            'centralized_action_id' => 'required_if:project_centralized_action,centralized_action',
        ]);

        /** @var object Crea una acción específica */
        $budgetSpecificAction = new BudgetSpecificAction([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->project_centralized_action === "project") {
            /** @var object Objeto que contiene información de un proyecto */
            $pry_acc = BudgetProject::find($request->project_id);
        }
        elseif ($request->project_centralized_action === "centralized_action") {
            /** @var object Objeto que contiene información de una acción centralizada */
            $pry_acc = BudgetCentralizedAction::find($request->centralized_action_id);
        }
        $pry_acc->specific_actions()->save($budgetSpecificAction);

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Muestra información de una acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function show()
    {
        return view('budget::show');
    }

    /**
     * Muestra el formulario para la edición de una acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción específica a modificar
     * @return Response
     */
    public function edit($id)
    {
        /** @var object Objeto con información de la acción específica a modificar */
        $BudgetSpecificAction = BudgetSpecificAction::find($id);

        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => ['budget.specific-actions.update', $BudgetSpecificAction->id], 
            'method' => 'PUT', 
            'role' => 'form'
        ];
        /** @var object Objeto con datos del modelo a modificar */
        $model = $BudgetSpecificAction;
        /** @var array Arreglo de opciones de proyectos a representar en la plantilla para su selección */
        $projects = $this->projects;
        /** @var array Arreglo de opciones de acciones centralizadas a representar en la plantilla para su selección */
        $centralized_actions = $this->centralized_actions;

        return view('budget::specific_actions.create-edit-form', compact(
            'header', 'model', 'projects', 'centralized_actions'
        ));
    }

    /**
     * Actualiza información de la acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id Identificador de la acción específica a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'project_centralized_action' => 'required',
            'project_id' => 'required_if:project_centralized_action,project',
            'centralized_action_id' => 'required_if:project_centralized_action,centralized_action',
        ]);

        if ($request->project_centralized_action === "project") {
            /** @var object Objeto que contiene información de un proyecto */
            $pry_acc = BudgetProject::find($request->project_id);
            $specificable_type = BudgetProject::class;
        }
        elseif ($request->project_centralized_action === "centralized_action") {
            /** @var object Objeto que contiene información de una acción centralizada */
            $pry_acc = BudgetCentralizedAction::find($request->centralized_action_id);
            $specificable_type = BudgetCentralizedAction::class;
        }

        /** @var object Objeto con información de la acción específica a modificar */
        $budgetSpecificAction = BudgetSpecificAction::find($id);
        $budgetSpecificAction->fill($request->all());
        $budgetSpecificAction->specificable_type = $specificable_type;
        $budgetSpecificAction->specificable_id = $pry_acc->id;
        $budgetSpecificAction->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Elimina una acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción específica a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con información de la acción específica a eliminar */
        $budgetSpecificAction = BudgetSpecificAction::find($id);

        if ($budgetSpecificAction) {
            $budgetSpecificAction->delete();
        }
        
        return response()->json(['record' => $budgetSpecificAction, 'message' => 'Success'], 200);
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
        /** @var object Objeto con información de las acciones específicas registradas */
        $specificActions = ($active !== null) 
                           ? BudgetSpecificAction::where('active', $active)->with('specificable')->get() 
                           : BudgetSpecificAction::with('specificable')->get();

        return response()->json(['records' => $specificActions], 200);
    }

    /**
     * Obtiene las acciones específicas registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  string  $type   Identifica si la acción a buscar es por proyecto o acción centralizada
     * @param  integer $id     Identificador de la acción centralizada a buscar, este parámetro es opcional
     * @param  string  $source Fuente de donde se realiza la consulta
     * @return JSON        JSON con los datos de las acciones específicas
     */
    public function getSpecificActions($type, $id, $source = null)
    {
        /** @var array Arreglo con información de las acciones específicas */
        $data = [['id' => '', 'text' => 'Seleccione...']];

        if ($type==="Project") {
            /** @var object Objeto con las acciones específicas asociadas a un proyecto */
            $specificActions = BudgetProject::find($id)->specific_actions()->get();
        }
        else if ($type == "CentralizedAction") {
            /** @var object Objeto con las acciones específicas asociadas a una acción centralizada */
            $specificActions = BudgetCentralizedAction::find($id)->specific_actions()->get();
        }

        foreach ($specificActions as $specificAction) {
            /** @var object Objeto que determina si la acción específica ya fue formulada para el último presupuesto */
            $existsFormulation = BudgetSubSpecificFormulation::where([
                'budget_specific_action_id' => $specificAction->id
            ])->orderBy('year', 'desc')->first();

            if (!$existsFormulation) {
                array_push($data, [
                    'id' => $specificAction->id,
                    'text' => $specificAction->code . " - " . $specificAction->name
                ]);
            }
        }

        return response()->json($data);
    }

    /**
     * Obtiene todas las acciones específicas agrupadas por Proyectos y Acciones Centralizadas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param string $formulated_year Año de formulación por el cual filtrar la información
     * @param boolean $formulated     Indica si se debe validar con una formulación de presupuesto
     * @return JSON                   JSON con los datos de las acciones específicas
     */
    public function getGroupAllSpecificActions($formulated_year = '', $formulated = false)
    {
        if ($formulated_year && strlen($formulated_year) > 4) {
            try {
                $formulated_year = Crypt::decrypt($formulated_year);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                //
            }
        }
        /** @var array Arreglo que contiene las acciones específicas agrupadas por proyectos */
        $dataProjects = ['text' => 'Proyectos', 'children' => []];
        /** @var array Arreglo que contiene las acciones específicas agrupadas por acciones centralizadas */
        $dataCentralizedActions = ['text' => 'Acciones Centralizadas', 'children' => []];

        /** @var array Arreglo que contiene las acciones específicas */
        $data = [['id' => '', 'text' => 'Seleccione...']];

        /** @var object Objeto que contiene información de las acciones específicas */
        $sp_accs = ($formulated_year) ? BudgetSpecificAction::whereYear('from_date', $formulated_year)
                                                            ->orWhereYear('to_date', $formulated_year)
                                                            ->with('specificable')
                                                            ->get()
                                      : BudgetSpecificAction::with('specificable')->get();

        /** Agrega las acciones específicas para cada grupo */
        foreach ($sp_accs as $sp_acc) {
            $filter = ($formulated) ? BudgetSubSpecificFormulation::where(
                [
                    'budget_specific_action_id' => $sp_acc->specificable_id,
                    'assigned' => true
                ]
            )->first() : '';

            if (str_contains($sp_acc->specificable_type, 'BudgetProject') && !is_null($filter)) {
                array_push($dataProjects['children'], [
                    'id' => $sp_acc->id,
                    'text' => "{$sp_acc->specificable->code} - {$sp_acc->code} | {$sp_acc->name}"
                ]);
            }
            else if (str_contains($sp_acc->specificable_type, 'BudgetCentralizedAction') && !is_null($filter)) {
                array_push($dataCentralizedActions['children'], [
                    'id' => $sp_acc->id,
                    'text' => "{$sp_acc->specificable->code} - {$sp_acc->code} | {$sp_acc->name}"
                ]);
            }
            else if ($formulated && is_null($filter)) {
                array_push($data, ['text' => 'Sin formulaciones registradas', 'children' => []]);
            }
        }

        /** Si el grupo Proyectos contiene registros los agrega a la lista */
        if (count($dataProjects['children']) > 0) {
            array_push($data, $dataProjects);
        }
        /** Si el grupo Acciones Centralizadas contiene registros los agrega a la lista */
        if (count($dataCentralizedActions['children']) > 0) {
            array_push($data, $dataCentralizedActions);
        }

        return response()->json($data);
    }

    /**
     * Obtiene detalles de una acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificar de la acción específica de la cual se requiere información
     * @return JSON        JSON con los datos de la acción específica
     */
    public function getDetail($id)
    {
        return response()->json([
            'result' => true, 'record' => BudgetSpecificAction::where('id', $id)->with('specificable')->first()
        ], 200);
    }
}
