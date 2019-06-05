<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollSocioeconomicInformation;

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
        $this->middleware('permission:payroll.socioeconomic.informations.list', ['only' => 'index']);
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
            'payroll_staff_id' => 'required|unique:payroll_socioeconomic_informations',
            'marital_status_id' => 'required'
        ]);
        $socioeconomic_information = new PayrollSocioeconomicInformation;
        $socioeconomic_information->full_name_twosome  = $request->full_name_twosome;
        $socioeconomic_information->id_number_twosome  = $request->id_number_twosome;
        $socioeconomic_information->birthdate_twosome  = $request->birthdate_twosome;
        $socioeconomic_information->payroll_staff_id  = $request->payroll_staff_id;
        $socioeconomic_information->marital_status_id  = $request->marital_status_id;
        $socioeconomic_information->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('payroll.socioeconomic-informations.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(PayrollSocioeconomicInformation $socioeconomic_information)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollSocioeconomicInformation $socioeconomic_information)
    {
        $this->validate($request, [
            'full_name_twosome' => 'nullable|max:100',
            'id_number_twosome' => 'nullable|max:12',
            'birthdate_twosome' => 'nullable|date',
            'payroll_staff_id' => 'required',
            'marital_status_id' => 'required'
        ]);
        $socioeconomic_information->full_name_twosome  = $request->full_name_twosome;
        $socioeconomic_information->id_number_twosome  = $request->id_number_twosome;
        $socioeconomic_information->birthdate_twosome  = $request->birthdate_twosome;
        $socioeconomic_information->payroll_staff_id  = $request->payroll_staff_id;
        $socioeconomic_information->marital_status_id  = $request->marital_status_id;
        $socioeconomic_information->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('payroll.socioeconomic-informations.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollSocioeconomicInformation $socioeconomic_information)
    {
        if ($request->ajax())
        {
            $socioeconomic_information->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('payroll.socioeconomic-informations.index');
    }

    public function list()
    {
        return response()->json(['records' => PayrollSocioeconomicInformation::with(['payroll_staff','marital_status'])->get()], 200);
    }

    public function staffsList()
    {
        return template_choices('Modules\Payroll\Models\PayrollStaff',['id_number','-','full_name'],'',true);
    }

    public function maritalStatusList()
    {
        return template_choices('App\Models\MaritalStatus','name','',true);
    }
}
