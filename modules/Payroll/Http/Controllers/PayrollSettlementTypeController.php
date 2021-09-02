<?php
/** Controladores de talento humano */
namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSettlementType;

/**
 * @class PayrollSettlementTypeController
 * @brief Controlador de tipos de liquidación
 *
 * Clase que gestiona los datos de tipos de liquidación
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollSettlementTypeController extends Controller
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
        $this->middleware('permission:payroll.settlement.types.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.settlement.types.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.settlement.types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.settlement.types.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->rules = [
            'name' => [],
            'motive' => ['required', 'max:10'],
            'payroll_concept_id' => ['required'],
        ];

        /** Define los atributos para los campos personalizados */
        $this->attributes = [
            'motive' => 'motivo',
            'payroll_concept_id' => 'concepto'
        ];
    }

    /**
     * Muestra todos los registros de tipos de liquidación
     *
     * @method    index
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @return    Renderable    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => PayrollSettlementType::all()], 200);
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
        $this->rules['name'] = ['required', 'unique:payroll_settlement_types,name'];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollSettlementType = PayrollSettlementType::create([
            'name' => $request->name,
            'motive' => $request->motive,
            'payroll_concept_id' => $request->payroll_concept_id
        ]);
        return response()->json(['record' => $payrollSettlementType, 'message' => 'Success'], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    show
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
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
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
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
     * Actualiza el tipo de liquidación
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
        $payrollSettlementType = PayrollSettlementType::find($id);
        $this->rules['name'] = ['required', 'unique:payroll_settlement_types,name,' . $payrollSettlementType->id];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollSettlementType->name = $request->name;
        $payrollSettlementType->motive = $request->motive;
        $payrollSettlementType->payroll_concept_id = $request->payroll_concept_id;
        $payrollSettlementType->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de liquidación
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
        $payrollSettlementType = PayrollSettlementType::find($id);
        $payrollSettlementType->delete();
        return response()->json(['record' => $payrollSettlementType, 'message' => 'Success'], 200);
    }
}
