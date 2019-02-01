<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetAditionalCredit;

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
        $records = BudgetAditionalCredit::all();
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
        $BudgetAditionalCredit = BudgetAditionalCredit::find($id);

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
            'records' => BudgetAditionalCredit::with(['institution', 'aditional_credit_accounts'])->get()
        ], 200);
    }
}
