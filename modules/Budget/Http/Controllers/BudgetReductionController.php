<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetModification;

class BudgetReductionController extends Controller
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
        $this->middleware('permission:budget.reduction.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.reduction.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.reduction.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.reduction.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = BudgetModification::where('type', 'R')->get();
        return view('budget::reductions.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'budget.reductions.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        $institutions = template_choices(
            'App\Models\Institution', ['acronym', '-', 'name'], ['active' => true]
        );

        return view('budget::reductions.create-edit-form', compact('header', 'institutions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $BudgetReduction = BudgetModification::find($id);

        if ($BudgetReduction) {
            $BudgetReduction->delete();
        }
        
        return response()->json(['record' => $BudgetReduction, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     * @return [type] [description]
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetModification::where('type', 'R')->with(['institution', 'budget_modificacion_accounts'])->get()
        ], 200);
    }
}
