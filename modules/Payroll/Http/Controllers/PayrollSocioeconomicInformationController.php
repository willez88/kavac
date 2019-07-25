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
 * @brief Controlador de información socioeconómica
 *
 * Clase que gestiona los datos de información socioeconómica
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('payroll::socioeconomic-informations.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('payroll::socioeconomic-informations.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
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
        $payroll_socioeconomic_information = new PayrollSocioeconomicInformation;
        $payroll_socioeconomic_information->full_name_twosome  = $request->full_name_twosome;
        $payroll_socioeconomic_information->id_number_twosome  = $request->id_number_twosome;
        $payroll_socioeconomic_information->birthdate_twosome  = $request->birthdate_twosome;
        $payroll_socioeconomic_information->payroll_staff_id  = $request->payroll_staff_id;
        $payroll_socioeconomic_information->marital_status_id  = $request->marital_status_id;
        $payroll_socioeconomic_information->save();

        if ($request->payroll_childrens && !empty($request->payroll_childrens)) {
            foreach ($request->payroll_childrens as $children) {
                $payroll_children = new PayrollChildren;
                $payroll_children->first_name = $children['first_name'];
                $payroll_children->last_name = $children['last_name'];
                $payroll_children->id_number = $children['id_number'];
                $payroll_children->birthdate = $children['birthdate'];
                $payroll_children->payroll_socioeconomic_information_id = $payroll_socioeconomic_information->id;
                $payroll_children->save();
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
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::where('id',$id)->with(['payroll_staff','marital_status','payroll_childrens'])->first();
        return response()->json(['record' => $payrollSocioeconomicInformation], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $payrollSocioeconomicInformation = PayrollSocioeconomicInformation::find($id);
        return view('payroll::socioeconomic-informations.create-edit', compact('payrollSocioeconomicInformation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $payroll_socioeconomic_information = PayrollSocioeconomicInformation::find($id);
        $this->validate($request, [
            'full_name_twosome' => 'nullable|max:200',
            'id_number_twosome' => 'nullable|max:12',
            'birthdate_twosome' => 'nullable|date',
            'payroll_staff_id' => 'required|unique:payroll_socioeconomic_informations,payroll_staff_id,'.$payroll_socioeconomic_information->id,
            'marital_status_id' => 'required'
        ]);

        $payroll_socioeconomic_information->full_name_twosome  = $request->full_name_twosome;
        $payroll_socioeconomic_information->id_number_twosome  = $request->id_number_twosome;
        $payroll_socioeconomic_information->birthdate_twosome  = $request->birthdate_twosome;
        $payroll_socioeconomic_information->payroll_staff_id  = $request->payroll_staff_id;
        $payroll_socioeconomic_information->marital_status_id  = $request->marital_status_id;
        $payroll_socioeconomic_information->save();

        //falta validar los datos que ya existen para no repetir
        if ($request->payroll_childrens && !empty($request->payroll_childrens)) {
            foreach ($request->payroll_childrens as $children) {
                $payroll_children = new PayrollChildren;
                $payroll_children->first_name = $children['first_name'];
                $payroll_children->last_name = $children['last_name'];
                $payroll_children->id_number = $children['id_number'];
                $payroll_children->birthdate = $children['birthdate'];
                $payroll_children->payroll_socioeconomic_information_id = $payroll_socioeconomic_information->id;
                $payroll_children->save();
            }
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.socioeconomic-informations.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $payroll_socioeconomic_information = PayrollSocioeconomicInformation::find($id);
        $payroll_socioeconomic_information->delete();
        return response()->json(['record' => $payroll_socioeconomic_information, 'message' => 'Success'], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => PayrollSocioeconomicInformation::with(['payroll_staff','marital_status','payroll_childrens'])->get()], 200);
    }
}
