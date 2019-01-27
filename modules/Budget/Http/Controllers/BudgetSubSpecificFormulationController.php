<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\CodeSetting;
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\BudgetAccountOpen;

/**
 * @class BudgetSubSpecificFormulationController
 * @brief Controlador de formulaciones de presupuesto por sub específicas
 * 
 * Clase que gestiona las formulaciones de presupuesto por sub específicas
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetSubSpecificFormulationController extends Controller
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
        $this->middleware('permission:budget.formulation.list', ['only' => 'index', 'vueList', 'show']);
        $this->middleware('permission:budget.formulation.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.formulation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.formulation.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = BudgetSubSpecificFormulation::all();
        return view('budget::formulations.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('budget::formulations.create-edit-form');
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
            'specific_action_id' => 'required',
            'currency_id' => 'required',
            'formulated_accounts.*' => 'required'
        ]);

        $year = date("Y");
        
        $codeSetting = CodeSetting::where("model", BudgetSubSpecificFormulation::class)->first();
        if (!$codeSetting) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
            ]], 200);
        }

        $validateStore = BudgetSubSpecificFormulation::validateStore([
            'budget_specific_action_id' => $request->specific_action_id,
            'currency_id' => $request->currency_id, 'year' => $year, 
            'institution_id' => $request->institution_id
        ]);
        if (!$validateStore) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Ya existe una formulación con los datos suministrados'
            ]], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix, strlen($codeSetting->format_digits), 
            (strlen($codeSetting->format_year) === 2) ? date("y") : $year,
            BudgetSubSpecificFormulation::class, 'code'
        );

        $formulation = BudgetSubSpecificFormulation::create([
            'code' => $code, 'year' => $year, 
            'total_formulated' => (float)$request->formulated_accounts[0]['total_year_amount'],
            'budget_specific_action_id' => $request->specific_action_id,
            'currency_id' => $request->currency_id,
            'institution_id' => $request->institution_id
        ]);

        foreach ($request->formulated_accounts as $formulated_account) {
            $f_acc = (object)$formulated_account;
            BudgetAccountOpen::create([
                'jan_amount' => (float)$f_acc->jan_amount, 'feb_amount' => (float)$f_acc->feb_amount, 
                'mar_amount' => (float)$f_acc->mar_amount, 'apr_amount' => (float)$f_acc->apr_amount, 
                'may_amount' => (float)$f_acc->may_amount, 'jun_amount' => (float)$f_acc->jun_amount, 
                'jul_amount' => (float)$f_acc->jul_amount, 'aug_amount' => (float)$f_acc->aug_amount, 
                'sep_amount' => (float)$f_acc->sep_amount, 'oct_amount' => (float)$f_acc->oct_amount, 
                'nov_amount' => (float)$f_acc->nov_amount, 'dec_amount' => (float)$f_acc->dec_amount,
                'total_year_amount' => (float)$f_acc->total_year_amount, 
                'total_real_amount' => (float)$f_acc->total_real_amount, 
                'total_estimated_amount' => (float)$f_acc->total_estimated_amount, 
                'budget_account_id' => $f_acc->id,
                'budget_sub_specific_formulation_id' => $formulation->id
            ]);
        }

        return response()->json(['result' => true], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        dd("mostrar formulación");
        //return view('budget::formulations.list');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $formulation = BudgetSubSpecificFormulation::find($id);
        return view('budget::formulations.create-edit-form', compact("formulation"));
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
        $budgetFormulation = BudgetSubSpecificFormulation::find($id);

        if ($budgetFormulation) {
            $budgetFormulation->delete();
        }
        
        return response()->json(['record' => $budgetFormulation, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     * @return [type] [description]
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetSubSpecificFormulation::with('currency')->with('specific_action')->get()
        ], 200);
    }
}
