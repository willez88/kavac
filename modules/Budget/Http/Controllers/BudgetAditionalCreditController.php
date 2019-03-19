<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetModification;
use App\Models\DocumentStatus;
use App\Models\CodeSetting;

/**
 * @class BudgetAditionalCreditController
 * @brief Controlador de Créditos Adicionales
 * 
 * Clase que gestiona las Créditos Adicionales
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetAditionalCreditController extends Controller
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
        $this->middleware('permission:budget.aditionalcredit.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.aditionalcredit.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.aditionalcredit.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.aditionalcredit.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = BudgetModification::where('type', 'C')->get();
        return view('budget::aditional_credits.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'budget.aditional-credits.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        $institutions = template_choices(
            'App\Models\Institution', ['acronym', '-', 'name'], ['active' => true]
        );

        return view('budget::aditional_credits.create-edit-form', compact('header', 'institutions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'approved_at' => 'required|date',
            'description' => 'required',
            'document' => 'required',
            'institution_id' => 'required',
            'budget_account_id' => 'required|array|min:1'
        ];

        $messages = [
            'budget_account_id.required' => 'Las cuentas presupestarias son obligatorias.',
        ];

        $codeSetting = CodeSetting::where("model", BudgetModification::class)
                                  ->where('type', 'budget.aditional-credits')->first();
        if (!$codeSetting) {
            $rules['code'] = 'required';
            $message['code.required'] = 'Debe configurar previamente el formato para el código a generar';
        }

        $this->validate($request, $rules, $messages);

        $documentStatus = DocumentStatus::where('action', 'AP')->first();
        $code = generate_registration_code(
            $codeSetting->format_prefix, strlen($codeSetting->format_digits), 
            (strlen($codeSetting->format_year) === 2) ? date("y") : $year,
            BudgetModification::class, 'code'
        );

        $budgetModification = BudgetModification::create([
            'type' => 'C',
            'code' => $code,
            'approved_at' => $request->approved_at,
            'description' => $request->description,
            'document' => $request->document,
            'institution_id' => $request->institution_id,
            'document_status_id' => $documentStatus->id
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.aditional-credits.index');
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
    public function edit()
    {
        return view('budget::aditional_credits.create-edit-form');
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
        $BudgetAditionalCredit = BudgetModification::find($id);

        if ($BudgetAditionalCredit) {
            $BudgetAditionalCredit->delete();
        }
        
        return response()->json(['record' => $BudgetAditionalCredit, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     * @return [type] [description]
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetModification::where('type', 'C')->with(['institution', 'budget_modificacion_accounts'])->get()
        ], 200);
    }
}
