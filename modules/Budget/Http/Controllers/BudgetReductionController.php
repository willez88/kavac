<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Institution;
use Modules\Budget\Models\BudgetModification;

/**
 * @class BudgetReductionController
 * @brief Controlador de reducciones presupuestarias
 * 
 * Clase que gestiona las reducciones presupuestarias
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetReductionController extends Controller
{
    use ValidatesRequests;

    public $header;
    public $institution;

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

        /** @var array Arreglo de opciones a implementar en el formulario */
        $this->header = [
            'route' => 'budget.reductions.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];

        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $this->institution = template_choices(Institution::class, ['acronym', '-', 'name'], ['active' => true]);
    }

    /**
     * Muestra un listado de reducciones de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function index()
    {
        /** @var object Objeto con información de las reducciones presupuestarias */
        $records = BudgetModification::where('type', 'R')->get();

        return view('budget::reductions.list');
    }

    /**
     * Muestra un formulario para la creación de redcciones presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function create()
    {
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = $this->header;
        /** @var array Arreglo de opciones de instituciones a representar en la plantilla para su selección */
        $institutions = $this->institution;

        return view('budget::reductions.create-edit-form', compact('header', 'institutions'));
    }

    /**
     * Guarda información de las reducciones presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra información de las reducciones presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param int $id Identificador de la reducción presupuestaria a mostrar
     * @return Response
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Muestra el formulario para la edición de formulaciones presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param int $id Identificador de la reducción presupuestaria a modificar
     * @return Response
     */
    public function edit($id)
    {
        return view('budget::edit');
    }

    /**
     * Actualiza información de las reducciones presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param Request $request Objeto con datos de la petición realizada
     * @param int $id          Identificador de la reducción presupuestaria a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Elimina una reducción presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param Request $request Objeto con datos de la petición realizada
     * @param int $id Identificador de la reducción presupuestaria a eliminar
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        /** @var object Objeto con información de la reducción presupuestaria a eliminar */
        $BudgetReduction = BudgetModification::find($id);

        if ($BudgetReduction) {
            $BudgetReduction->delete();
        }
        
        return response()->json(['record' => $BudgetReduction, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return json JSON con información de las reducciones presupuestarias
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetModification::where('type', 'R')->with(['institution', 'budget_modificacion_accounts'])->get()
        ], 200);
    }
}
