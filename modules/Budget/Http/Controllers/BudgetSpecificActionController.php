<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetCentralizedAction;
use Modules\Budget\Models\BudgetSpecificAction;

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
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('budget::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'budget.specific-actions.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        $projects = template_choices(
            'Modules\Budget\Models\BudgetProject', ['code', '-', 'name'], ['active' => true]
        );
        $centralized_actions = template_choices(
            'Modules\Budget\Models\BudgetCentralizedAction', ['code', '-', 'name'], ['active' => true]
        );
        return view('budget::specific_actions.create-edit-form', compact(
            'header', 'projects', 'centralized_actions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
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

        $budgetSpecificAction = new BudgetSpecificAction([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->project_centralized_action === "project") {
            $pry_acc = BudgetProject::find($request->project_id);
        }
        elseif ($request->project_centralized_action === "centralized_action") {
            $pry_acc = BudgetCentralizedAction::find($request->centralized_action_id);
        }
        $pry_acc->specific_actions()->save($budgetSpecificAction);

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $BudgetSpecificAction = BudgetSpecificAction::find($id);
        $header = [
            'route' => ['budget.specific-actions.update', $BudgetSpecificAction->id], 
            'method' => 'PUT', 
            'role' => 'form'
        ];
        $model = $BudgetSpecificAction;
        $projects = template_choices(
            'Modules\Budget\Models\BudgetProject', ['code', '-', 'name'], ['active' => true]
        );
        $centralized_actions = template_choices(
            'Modules\Budget\Models\BudgetCentralizedAction', ['code', '-', 'name'], ['active' => true]
        );
        return view('budget::specific_actions.create-edit-form', compact(
            'header', 'model', 'projects', 'centralized_actions'
        ));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
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
            $pry_acc = BudgetProject::find($request->project_id);
            $specificable_type = "Modules\Budget\Models\BudgetProject";
        }
        elseif ($request->project_centralized_action === "centralized_action") {
            $pry_acc = BudgetCentralizedAction::find($request->centralized_action_id);
            $specificable_type = "Modules\Budget\Models\BudgetCentralizedAction";
        }
        $budgetSpecificAction = BudgetSpecificAction::find($id);
        $budgetSpecificAction->fill($request->all());
        $budgetSpecificAction->specificable_type = $specificable_type;
        $budgetSpecificAction->specificable_id = $pry_acc->id;
        $budgetSpecificAction->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
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
        $specificActions = ($active !== null) 
                           ? BudgetSpecificAction::where('active', $active)->with('specificable')->get() 
                           : BudgetSpecificAction::with('specificable')->get();

        return response()->json(['records' => $specificActions], 200);
    }

    /**
     * Obtiene las acciones específicas registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la acción centralizada a buscar, este parámetro es opcional
     * @return JSON        JSON con los datos de las acciones específicas
     */
    public function getSpecificActions($type, $id)
    {
        $data = [['id' => '', 'text' => 'Seleccione...']];
        if ($type==="Project") {
            $specificActions = BudgetProject::find($id)->specific_actions()->get();
        }
        else if ($type == "CentralizedAction") {
            $specificActions = BudgetCentralizedAction::find($id)->specific_actions()->get();
        }
        
        foreach ($specificActions as $specificAction) {
            array_push($data, [
                'id' => $specificAction->id,
                'text' => $specificAction->code . " - " . $specificAction->name
            ]);
        }

        return response()->json($data);
    }

    /**
     * Obtiene todas las acciones específicas agrupadas por Proyectos y Acciones Centralizadas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param string $formulated_year Año de formulación por el cual filtrar la información
     * @return JSON                   JSON con los datos de las acciones específicas
     */
    public function getGroupAllSpecificActions($formulated_year = '')
    {
        /** Inicializa los grupos a los cuales asignar las acciones específicas */
        $dataProjects = ['text' => 'Proyectos', 'children' => []];
        $dataCentralizedActions = ['text' => 'Acciones Centralizadas', 'children' => []];
        $data = [['id' => '', 'text' => 'Seleccione...']];

        $sp_accs = ($formulated_year) ? BudgetSpecificAction::whereYear('from_date', $formulated_year)
                                                            ->orWhereYear('to_date', $formulated_year)
                                                            ->with('specificable')
                                                            ->get()
                                      : BudgetSpecificAction::with('specificable')->get();

        /** Agrega las acciones específicas para cada grupo */
        foreach ($sp_accs as $sp_acc) {
            if (str_contains($sp_acc->specificable_type, 'BudgetProject')) {
                array_push($dataProjects['children'], [
                    'id' => $sp_acc->id,
                    'text' => "{$sp_acc->specificable->code} - {$sp_acc->code} | {$sp_acc->name}"
                ]);
            }
            else if (str_contains($sp_acc->specificable_type, 'BudgetCentralizedAction')) {
                array_push($dataCentralizedActions['children'], [
                    'id' => $sp_acc->id,
                    'text' => "{$sp_acc->specificable->code} - {$sp_acc->code} | {$sp_acc->name}"
                ]);
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
