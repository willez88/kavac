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
        return view('budget::projects.create-edit-form', compact(
            'header', 'model', 'projects', 'centralized_actions'
        ));
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
}
