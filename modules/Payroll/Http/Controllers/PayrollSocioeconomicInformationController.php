<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSocioeconomicInformation;
use Modules\Payroll\Models\PayrollChildren;

/**
 * @class PayrollSocioeconomicInformationController
 * @brief Controlador de información socioeconómica del trabajador
 *
 * Clase que gestiona los datos de información socioeconómica del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollSocioeconomicInformationController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.socioeconomic.informations.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.socioeconomic.informations.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.socioeconomic.informations.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.socioeconomic.informations.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra todos los registros de información socioeconómica del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::socioeconomic-informations.index');
    }

    /**
     * Muestra el formulario de registro de información socioeconómica del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\View\View    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::socioeconomic-informations.create-edit');
    }

    /**
     * Valida y registra una nueva información socioeconómica del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name_twosome' => 'nullable|max:200',
            'id_number_twosome' => 'nullable|max:12',
            'birthdate_twosome' => 'nullable|date',
            'payroll_staff_id' => 'required|unique:payroll_socioeconomic_informations,payroll_staff_id',
            'marital_status_id' => 'required'
        ]);
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::create([
            'full_name_twosome' => $request->full_name_twosome,
            'id_number_twosome' => $request->id_number_twosome,
            'birthdate_twosome' => $request->birthdate_twosome,
            'payroll_staff_id' => $request->payroll_staff_id,
            'marital_status_id' => $request->marital_status_id
        ]);

        if ($request->payroll_childrens && !empty($request->payroll_childrens)) {
            foreach ($request->payroll_childrens as $payrollChildren) {
                PayrollChildren::create([
                    'first_name' => $payrollChildren['first_name'],
                    'last_name' => $payrollChildren['last_name'],
                    'id_number' => $payrollChildren['id_number'],
                    'birthdate' => $payrollChildren['birthdate'],
                    'payroll_socioeconomic_information_id' => $payrollSocioeconomicInformation->id
                ]);
            }
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.socioeconomic-informations.index')], 200);
    }

    /**
     * Muestra los datos de la información socioeconómica del trabajador en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador del dato a mostrar
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información socioeconómica del trabajador
     */
    public function show($id)
    {
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::where('id', $id)->with(['payrollStaff','marital_status','payroll_childrens'])->first();
        return response()->json(['record' => $payrollSocioeconomicInformation], 200);
    }

    /**
     * Muestra el formulario de actualización de información socioeconómica del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id              Identificador con el dato a actualizar
     * @return \Illuminate\View\View    Vista con el formulario y el objeto con el dato a actualizar
     */
    public function edit($id)
    {
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::find($id);
        return view('payroll::socioeconomic-informations.create-edit', compact('payrollSocioeconomicInformation'));
    }

    /**
     * Actualiza la información socioeconómica del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del dato a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::find($id);
        $this->validate($request, [
            'full_name_twosome' => 'nullable|max:200',
            'id_number_twosome' => 'nullable|max:12',
            'birthdate_twosome' => 'nullable|date',
            'payroll_staff_id' => 'required|unique:payroll_socioeconomic_informations,payroll_staff_id,'.$payrollSocioeconomicInformation->id,
            'marital_status_id' => 'required'
        ]);

        $payrollSocioeconomicInformation->full_name_twosome  = $request->full_name_twosome;
        $payrollSocioeconomicInformation->id_number_twosome  = $request->id_number_twosome;
        $payrollSocioeconomicInformation->birthdate_twosome  = $request->birthdate_twosome;
        $payrollSocioeconomicInformation->payroll_staff_id  = $request->payroll_staff_id;
        $payrollSocioeconomicInformation->marital_status_id  = $request->marital_status_id;
        $payrollSocioeconomicInformation->save();

        //falta validar los datos que ya existen para no repetir
        if ($request->payroll_childrens && !empty($request->payroll_childrens)) {
            foreach ($request->payroll_childrens as $payrollChildren) {
                PayrollChildren::create([
                    'first_name' => $payrollChildren['first_name'],
                    'last_name' => $payrollChildren['last_name'],
                    'id_number' => $payrollChildren['id_number'],
                    'birthdate' => $payrollChildren['birthdate'],
                    'payroll_socioeconomic_information_id' => $payrollSocioeconomicInformation->id
                ]);
            }
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.socioeconomic-informations.index')], 200);
    }

    /**
     * Elimina la información socioeconómica del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del dato a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::find($id);
        $payrollSocioeconomicInformation->delete();
        return response()->json(['record' => $payrollSocioeconomicInformation, 'message' => 'Success'], 200);
    }

    /**
     * Muestra la información socioeconómica del trabajador registrada
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información socioeconómica del trabajador
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollSocioeconomicInformation::with(['payrollStaff','marital_status','payroll_childrens'])->get()], 200);
    }
}
