<?php
/** Controladores de talento humano */
namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollRelationship;

/**
 * @class PayrollRelationshipController
 * @brief Controlador de parentescos
 *
 * Clase que gestiona los datos de parentescos
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollRelationshipController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.relationships.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.relationships.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.relationships.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.relationships.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de parentescos
     *
     * @method    index
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @return    Renderable    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => PayrollRelationship::all()], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    create
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function create()
    {
        return view('payroll::create');
    }

    /**
     * Valida y registra un nuevo tipo de liquidación
     *
     * @method    store
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param     object    Request    $request    Objeto con información de la petición
     *
     * @return    Renderable    Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:payroll_relationships,name'],
            'description' => ['nullable', 'max:200']
        ]);

        $payrollRelationship = PayrollRelationship::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json(['record' => $payrollRelationship, 'message' => 'Success'], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    show
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function show($id)
    {
        return view('payroll::show');
    }

    /**
     * [descripción del método]
     *
     * @method    edit
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function edit($id)
    {
        return view('payroll::edit');
    }

    /**
     * Actualiza el parentesco
     *
     * @method    update
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     *
     * @return    Renderable    Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollRelationship = PayrollRelationship::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:payroll_relationships,name,'.$payrollRelationship->id],
            'description' => ['nullable', 'max:200']
        ]);

        $payrollRelationship->name = $request->name;
        $payrollRelationship->description = $request->description;
        $payrollRelationship->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el parentesco
     *
     * @method    destroy
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollRelationship = PayrollRelationship::find($id);
        $payrollRelationship->delete();
        return response()->json(['record' => $payrollRelationship, 'message' => 'Success'], 200);
    }
}
