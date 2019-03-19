<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Budget\Models\BudgetModification;

class BudgetTransferController extends Controller
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
        $this->middleware('permission:budget.transfer.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.transfer.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.transfer.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.transfer.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = BudgetModification::where('type', 'T')->get();
        return view('budget::transfers.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'budget.transfers.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        $institutions = template_choices(
            'App\Models\Institution', ['acronym', '-', 'name'], ['active' => true]
        );

        return view('budget::transfers.create-edit-form', compact('header', 'institutions'));
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
        $BudgetTransfer = BudgetModification::find($id);

        if ($BudgetTransfer) {
            $BudgetTransfer->delete();
        }
        
        return response()->json(['record' => $BudgetTransfer, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     * @return [type] [description]
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetModification::where('type', 'T')->with(['institution', 'budget_modificacion_accounts'])->get()
        ], 200);
    }
}
