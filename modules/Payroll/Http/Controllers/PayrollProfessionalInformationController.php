<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollProfessionalInformation;

/**
 * @class PayrollprofessionalInformationController
 * @brief Controlador de información profesional
 *
 * Clase que gestiona los datos de información profesional
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollProfessionalInformationController extends Controller
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
        $this->middleware('permission:payroll.professional.informations.list', ['only' => 'index']);
        $this->middleware('permission:payroll.professional.informations.create', ['only' => 'store']);
        $this->middleware('permission:payroll.professional.informations.edit', ['only' => 'update']);
        $this->middleware('permission:payroll.professional.informations.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('payroll::professional-informations.index');
        //return view('payroll::professional-informations.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('payroll::professional-informations.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payroll_staff_id' => 'required|unique:payroll_professional_informations,payroll_staff_id',
            'payroll_instruction_degree_id' => 'required',
            'payroll_language_id' => 'required',
            'payroll_language_level_id' => 'required'
        ]);

        $payroll_professional_information = new PayrollProfessionalInformation;
        $payroll_professional_information->payroll_staff_id = $request->payroll_staff_id;
        $payroll_professional_information->payroll_instruction_degree_id = $request->payroll_instruction_degree_id;

        if( $request->payroll_instruction_degree_id == 1 || $request->payroll_instruction_degree_id == 2 ||
            $request->payroll_instruction_degree_id == 3 || $request->payroll_instruction_degree_id == 6 ||
            $request->payroll_instruction_degree_id == 7 || $request->payroll_instruction_degree_id == 8) {
            $payroll_professional_information->profession_id = null;
        }
        else {
            $this->validate($request, [
                'profession_id' => 'required'
            ]);
            $payroll_professional_information->profession_id = $request->profession_id;
        }

        if( $request->payroll_instruction_degree_id == 6 || $request->payroll_instruction_degree_id == 7 ||
            $request->payroll_instruction_degree_id == 8 ) {
            $this->validate($request, [
                'instruction_degree_name' => 'required'
            ]);
            $payroll_professional_information->instruction_degree_name = $request->instruction_degree_name;
        }

        $payroll_professional_information->is_student = $request->is_student;

        if( $payroll_professional_information->is_student ) {
            $this->validate($request, [
                'payroll_study_type_id' => 'required',
                'study_program_name' => 'required',
                'class_schedule' => 'required'
            ]);
            $payroll_professional_information->payroll_study_type_id = $request->payroll_study_type_id;
            $payroll_professional_information->study_program_name = $request->study_program_name;
            $payroll_professional_information->class_schedule = $request->class_schedule;
        }
        else {
            $payroll_professional_information->payroll_study_type_id = null;
            $payroll_professional_information->study_program_name = null;
            $payroll_professional_information->class_schedule = null;
        }

        $payroll_professional_information->payroll_language_id = $request->payroll_language_id;
        $payroll_professional_information->payroll_language_level_id = $request->payroll_language_level_id;
        $payroll_professional_information->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $payroll_professional_information = PayrollProfessionalInformation::findorfail($id);
        $data[] = [
            'payroll_staff' => $payroll_professional_information->payroll_staff->full_name,
            'payroll_instruction_degree' => $payroll_professional_information->payroll_instruction_degree->name,
            'profession' => ($payroll_professional_information->profession_id) ? $payroll_professional_information->profession->name : null,
            'is_student' => $payroll_professional_information->is_student,
            'payroll_study_type' => ($payroll_professional_information->payroll_study_type_id) ? $payroll_professional_information->payroll_study_type->name : null,
            'study_program_name' => ($payroll_professional_information->study_program_name) ? $payroll_professional_information->study_program_name : null,
            'class_schedule' => ($payroll_professional_information->class_schedule) ? $payroll_professional_information->class_schedule : null,
            'payroll_language' => $payroll_professional_information->payroll_language->name,
            'payroll_language_level' => $payroll_professional_information->payroll_language_level->name,
        ];
        return response()->json(['record' => $data[0]], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $professional_information = PayrollProfessionalInformation::find($id);
        return view('payroll::professional-informations.create-edit', compact('professional_information'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $payroll_professional_information = PayrollProfessionalInformation::find($id);
        $this->validate($request, [
            'payroll_staff_id' => 'required|unique:payroll_professional_informations,payroll_staff_id,'.$payroll_professional_information->id,
            'payroll_instruction_degree_id' => 'required',
            'payroll_language_id' => 'required',
            'payroll_language_level_id' => 'required'
        ]);

        $payroll_professional_information->payroll_staff_id = $request->payroll_staff_id;
        $payroll_professional_information->payroll_instruction_degree_id = $request->payroll_instruction_degree_id;

        if( $request->payroll_instruction_degree_id == 1 || $request->payroll_instruction_degree_id == 2 ||
            $request->payroll_instruction_degree_id == 3 || $request->payroll_instruction_degree_id == 6 ||
            $request->payroll_instruction_degree_id == 7 || $request->payroll_instruction_degree_id == 8) {
            $payroll_professional_information->profession_id = null;
        }
        else {
            $this->validate($request, [
                'profession_id' => 'required'
            ]);
            $payroll_professional_information->profession_id = $request->profession_id;
        }

        if( $request->payroll_instruction_degree_id == 6 || $request->payroll_instruction_degree_id == 7 ||
            $request->payroll_instruction_degree_id == 8 ) {
            $this->validate($request, [
                'instruction_degree_name' => 'required'
            ]);
            $payroll_professional_information->instruction_degree_name = $request->instruction_degree_name;
        }

        if( $request->is_student ) {
            $this->validate($request, [
                'payroll_study_type_id' => 'required',
                'study_program_name' => 'required',
                'class_schedule' => 'required'
            ]);
            $payroll_professional_information->is_student = $request->is_student;
            $payroll_professional_information->payroll_study_type_id = $request->payroll_study_type_id;
            $payroll_professional_information->study_program_name = $request->study_program_name;
            $payroll_professional_information->class_schedule = $request->class_schedule;
        }
        else {
            $payroll_professional_information->is_student = false;
            $payroll_professional_information->payroll_study_type_id = null;
            $payroll_professional_information->study_program_name = null;
            $payroll_professional_information->class_schedule = null;
        }

        $payroll_professional_information->payroll_language_id = $request->payroll_language_id;
        $payroll_professional_information->payroll_language_level_id = $request->payroll_language_level_id;
        $payroll_professional_information->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $payroll_professional_information = PayrollProfessionalInformation::find($id);
        $payroll_professional_information->delete();
        return response()->json(['record' => $payroll_professional_information, 'message' => 'Success'], 200);
    }

    public function professionsList()
    {
        return template_choices('App\Models\Profession','name','',true);
    }

    public function vueList()
    {
        return response()->json(['records' => PayrollProfessionalInformation::with([
            'payroll_staff', 'payroll_instruction_degree','profession',
            'payroll_study_type','payroll_language','payroll_language_level'
        ])->get()], 200);
    }
}
