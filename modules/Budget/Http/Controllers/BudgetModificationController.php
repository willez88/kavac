<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetModification;

class BudgetModificationController extends Controller
{
    public $header;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:budget.modificacions.list', ['only' => 'index', 'vueList']);
        /*$this->middleware('permission:budget.modificacions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.modificacions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.modificacions.delete', ['only' => 'destroy']);*/

        /** @var array Arreglo de opciones a implementar en el formulario */
        $this->header = [
            'route' => 'budget.modifications.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('budget::modifications.list');
    }

    /**
     * Muestra el formulario para crear un crédito adicional
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function create($type)
    {
        $viewTemplate = ($type==="AC") 
                        ? 'aditional_credits' 
                        : (($type==='RE') 
                          ? 'reductions' 
                          : (($type==="TR") 
                            ? 'transfers' : ''));

        return view("budget::$viewTemplate.create-edit-form", compact('type'));
    }

    public function store(Request $request)
    {

    }

    public function edit($type, BudgetModification $modification)
    {

    }

    public function update(Request $request, BudgetModification $modification)
    {

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con información de la modificación presupuestaria a eliminar */
        $budgetModification = BudgetModification::find($id);

        if ($budgetModification) {
            $budgetModification->delete();
        }
        
        return response()->json(['record' => $budgetModification, 'message' => 'Success'], 200);
    }
}
