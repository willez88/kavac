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
use Modules\Budget\Models\BudgetCentralizedAction;

class BudgetCentralizedActionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
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
            'route' => 'budget.centralized-actions.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        $institutions = Institution::template_choices();
        $departments = Department::template_choices();
        $positions = PayrollPosition::template_choices();
        $staffs = PayrollStaff::template_choices();
        return view('budget::centralized_actions.create-edit-form', compact(
            'header', 'institutions', 'departments', 'positions', 'staffs'
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
            'institution_id' => 'required',
            'department_id' => 'required',
            'payroll_position_id' => 'required',
            'payroll_staff_id' => 'required',
            'code' => 'required',
            'custom_date' => 'required|date',
            'name' => 'required',
        ]);

        /**
         * Registra el nuevo proyecto
         */
        BudgetCentralizedAction::create([
            'name' => $request->name,
            'code' => $request->code,
            'custom_date' => $request->custom_date,
            'active' => ($request->active!==null),
            'department_id' => $request->department_id,
            'payroll_position_id' => $request->payroll_position_id,
            'payroll_staff_id' => $request->payroll_staff_id
        ]);

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
        $budgetCentralizedAction = BudgetCentralizedAction::find($id);
        $header = [
            'route' => ['budget.centralized-actions.update', $budgetCentralizedAction->id], 
            'method' => 'PUT', 
            'role' => 'form'
        ];
        $model = $budgetCentralizedAction;
        $institutions = Institution::template_choices();
        $departments = Department::template_choices();
        $positions = PayrollPosition::template_choices();
        $staffs = PayrollStaff::template_choices();
        return view('budget::centralized_actions.create-edit-form', compact(
            'header', 'model', 'institutions', 'departments', 'positions', 'staffs'
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
            'institution_id' => 'required',
            'department_id' => 'required',
            'payroll_position_id' => 'required',
            'payroll_staff_id' => 'required',
            'code' => 'required',
            'custom_date' => 'required|date',
            'name' => 'required',
        ]);

        $budgetCentralizedAction = BudgetCentralizedAction::find($id);
        $budgetCentralizedAction->fill($request->all());
        $budgetCentralizedAction->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $budgetCentralizedAction = BudgetCentralizedAction::find($id);

        if ($budgetCentralizedAction) {
            $budgetCentralizedAction->delete();
        }
        
        return response()->json(['record' => $budgetCentralizedAction, 'message' => 'Success'], 200);
    }

    public function vueList()
    {
        return response()->json([
            'records' => BudgetCentralizedAction::where('active', true)->with('payroll_staff')->get()
        ], 200);
    }
}
