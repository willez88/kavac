<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetCentralizedAction;
use Modules\Budget\Models\BudgetSpecificAction;

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

    public function vueList()
    {
        return response()->json([
            'records' => BudgetSpecificAction::where('active', true)->with('specificable')->get()
        ], 200);
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
        $data = [];
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
}
