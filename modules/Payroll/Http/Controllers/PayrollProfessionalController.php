<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollProfessional;
use Modules\Payroll\Models\Profession;
use Modules\Payroll\Models\PayrollLanguage;
use Modules\Payroll\Models\PayrollLanguageLevel;
use Modules\Payroll\Models\PayrollInstructionDegree;
use Modules\Payroll\Models\Document;
use Modules\Payroll\Models\PayrollClassSchedule;
use Modules\Payroll\Rules\PayrollLangProfUnique;
use Illuminate\Support\Facades\DB;

/**
 * @class PayrollProfessionalController
 * @brief Controlador de información profesional del trabajador
 *
 * Clase que gestiona los datos de información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollProfessionalController extends Controller
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
        $this->middleware('permission:payroll.professionals.list', ['only' => ['index', 'vueList']]);
        $this->middleware('permission:payroll.professionals.create', ['only' => 'store']);
        $this->middleware('permission:payroll.professionals.edit', ['only' => ['create', 'update']]);
        $this->middleware('permission:payroll.professionals.delete', ['only' => 'destroy']);

        /** Define las reglas de validación para el formulario */
        $this->rules = [
            'payroll_instruction_degree_id' => ['required'],
        ];

        /** Define los atributos para los campos personalizados */
        $this->attributes = [
            'payroll_staff_id' => 'trabajador',
            'payroll_instruction_degree_id' => 'grado de instrucción',
        ];
    }

    /**
     * Muestra todos los registros de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return Renderable    Muestra los datos organizados en una tabla
     */
    public function index()
    {
        return view('payroll::professionals.index');
    }

    /**
     * Muestra el formulario de registro de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return Renderable    Vista con el formulario
     */
    public function create()
    {
        return view('payroll::professionals.create-edit');
    }

    /**
     * Valida y registra una nueva información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\JsonResponse        Json: result en verdadero y redirect con la url a donde ir
     */
    public function store(Request $request)
    {
        $this->rules['payroll_staff_id'] = ['required', 'unique:payroll_professionals,payroll_staff_id'];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollInstructionDegree1 = PayrollInstructionDegree::where('name', 'TSU Universitario')->first()->id;
        $payrollInstructionDegree2 = PayrollInstructionDegree::where('name', 'Universitario Pregrado')->first()->id;
        if ($request->payroll_instruction_degree_id == $payrollInstructionDegree1 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree2
        ) {
            $this->validate(
                $request,
                [
                    'professions' => ['required', 'array', 'min:1'],
                ],
                [],
                [
                    'professions' => 'profesiones',
                ],
            );
        }
        $payrollInstructionDegree3 = PayrollInstructionDegree::where('name', 'Especialización')->first()->id;
        $payrollInstructionDegree4 = PayrollInstructionDegree::where('name', 'Maestría')->first()->id;
        $payrollInstructionDegree5 = PayrollInstructionDegree::where('name', 'Doctorado')->first()->id;
        if ($request->payroll_instruction_degree_id == $payrollInstructionDegree3 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree4 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree5
        ) {
            $this->validate(
                $request,
                [
                    'instruction_degree_name' => ['required'],
                ],
                [],
                [
                    'instruction_degree_name' => 'nombre de especialización, maestría o doctorado',
                ],
            );
        }
        if ($request->is_student) {
            $this->validate(
                $request,
                [
                    'payroll_study_type_id' => ['required'],
                    'study_program_name' => ['required'],
                    'class_schedule' => ['nullable'],
                ],
                [],
                [
                    'payroll_study_type_id' => 'tipo de estudio',
                    'study_program_name' => 'nombre del programa de estudio',
                ],
            );
        }

        DB::transaction(function () use ($request) {
            $payrollProfessional = PayrollProfessional::create([
                'payroll_staff_id' => $request->payroll_staff_id,
                'payroll_instruction_degree_id' => $request->payroll_instruction_degree_id,
                'instruction_degree_name' => $request->instruction_degree_name,
                'is_student' => ($request->is_student!==null),
                'payroll_study_type_id' => ($request->is_student) ? $request->payroll_study_type_id : null,
                'study_program_name' => ($request->is_student) ? $request->study_program_name : null,
                'class_schedule' => ($request->is_student) ? $request->class_schedule : null,
            ]);
            $payroll_class_schedule = PayrollClassSchedule::create(
                ['payroll_professional_id' => $payrollProfessional->id]
            );
            foreach ($request->class_schedule_ids as $class_schedule_id) {
                $document = Document::find($class_schedule_id['id']);
                $document->documentable_type = PayrollClassSchedule::class;
                $document->documentable_id = $payroll_class_schedule->id;
                $document->save();
            }
            $i = 0;
            foreach ($request->payroll_languages as $payroll_language) {
                $this->validate(
                    $request,
                    [
                        'payroll_languages.'.$i.'.payroll_lang_id' => [
                            'required',
                            new PayrollLangProfUnique($payrollProfessional->id, $payroll_language['payroll_lang_id'])
                        ],
                        'payroll_languages.'.$i.'.payroll_language_level_id' => ['required'],
                    ],
                    [],
                    [
                        'payroll_languages.'.$i.'.payroll_lang_id' => 'idioma #'.($i+1),
                        'payroll_languages.'.$i.'.payroll_language_level_id' => 'nivel de idioma #'.($i+1),
                    ],
                );
                $payroll_lang = PayrollLanguage::find($payroll_language['payroll_lang_id']);
                $payroll_language_level = PayrollLanguageLevel::find($payroll_language['payroll_language_level_id']);
                $payrollProfessional->payrollLanguages()->attach(
                    $payroll_lang->id,
                    ['payroll_language_level_id' => $payroll_language_level->id]
                );
                $i++;
            }
            foreach ($request->professions as $profession) {
                $prof = Profession::find($profession['id']);
                $payrollProfessional->professions()->attach($prof);
            }
        });
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.professionals.index')], 200);
    }

    /**
     * Muestra los datos de la información profesional del trabajador en específico
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                          Identificador del dato a mostrar
     * @return \Illuminate\Http\JsonResponse        Json con el dato de la información profesional del trabajador
     */
    public function show($id)
    {
        $payrollProfessional = PayrollProfessional::where('id', $id)->with([
            'payrollStaff','payrollInstructionDegree','professions','payrollStudyType',
            'payrollLanguages', 'payrollClassSchedule' => function ($query) {
                $query->with('documents');
            },
        ])->first();
        return response()->json(['record' => $payrollProfessional], 200);
    }

    /**
     * Muestra el formulario de actualización de información profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id              Identificador con el dato a actualizar
     * @return Renderable    Vista con el formulario y el objeto con el dato a actualizar
     */
    public function edit($id)
    {
        $payrollProfessional = PayrollProfessional::find($id);
        return view('payroll::professionals.create-edit', compact('payrollProfessional'));
    }

    /**
     * Actualiza la información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del dato a actualizar
     * @return \Illuminate\Http\JsonResponse        Json con la redirección y mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $payrollProfessional = PayrollProfessional::find($id);
        $this->rules['payroll_staff_id'] = [
            'required',
            'unique:payroll_professionals,payroll_staff_id,'.$payrollProfessional->id,
        ];
        $this->validate($request, $this->rules, [], $this->attributes);
        $payrollInstructionDegree1 = PayrollInstructionDegree::where('name', 'TSU Universitario')->first()->id;
        $payrollInstructionDegree2 = PayrollInstructionDegree::where('name', 'Universitario Pregrado')->first()->id;
        if ($request->payroll_instruction_degree_id == $payrollInstructionDegree1 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree2
        ) {
            $this->validate(
                $request,
                [
                    'professions' => ['required', 'array', 'min:1'],
                ],
                [],
                [
                    'professions' => 'profesiones',
                ],
            );
        }

        $payrollInstructionDegree3 = PayrollInstructionDegree::where('name', 'Especialización')->first()->id;
        $payrollInstructionDegree4 = PayrollInstructionDegree::where('name', 'Maestría')->first()->id;
        $payrollInstructionDegree5 = PayrollInstructionDegree::where('name', 'Doctorado')->first()->id;
        if ($request->payroll_instruction_degree_id == $payrollInstructionDegree3 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree4 ||
            $request->payroll_instruction_degree_id == $payrollInstructionDegree5
        ) {
            $this->validate(
                $request,
                [
                    'instruction_degree_name' => ['required'],
                ],
                [],
                [
                    'instruction_degree_name' => 'nombre de especialización, maestría o doctorado',
                ],
            );
        }

        if ($request->is_student) {
            $this->validate(
                $request,
                [
                    'payroll_study_type_id' => ['required'],
                    'study_program_name' => ['required'],
                    'class_schedule' => ['nullable'],
                ],
                [],
                [
                    'payroll_study_type_id' => 'tipo de estudio',
                    'study_program_name' => 'nombre del programa de estudio',
                ],
            );
        }

        DB::transaction(function () use ($payrollProfessional, $request) {
            $payrollProfessional->payroll_staff_id = $request->payroll_staff_id;
            $payrollProfessional->payroll_instruction_degree_id = $request->payroll_instruction_degree_id;
            $payrollProfessional->is_student = ($request->is_student!==null);
            $payrollProfessional
                ->payroll_study_type_id = ($request->is_student) ? $request->payroll_study_type_id : null;
            $payrollProfessional->study_program_name = ($request->is_student) ? $request->study_program_name : null;
            $payrollProfessional->class_schedule = ($request->is_student) ? $request->class_schedule: null;
            $payrollProfessional->save();

            foreach ($request->class_schedule_ids as $class_schedule_id) {
                $document = Document::find($class_schedule_id['id']);
                $document->documentable_type = PayrollClassSchedule::class;
                $document->documentable_id = $payrollProfessional->payroll_class_schedule->id;
                $document->save();
            }
            foreach ($payrollProfessional->payrollLanguages as $payrollLanguage) {
                $payroll_lang = PayrollLanguage::find($payrollLanguage['id']);
                $payrollProfessional->payrollLanguages()->detach($payroll_lang->id);
            }
            $i = 0;
            foreach ($request->payroll_languages as $payroll_language) {
                $this->validate(
                    $request,
                    [
                        'payroll_languages.'.$i.'.payroll_lang_id' => [
                            'required',
                            new PayrollLangProfUnique($payrollProfessional->id, $payroll_language['payroll_lang_id'])
                        ],
                        'payroll_languages.'.$i.'.payroll_language_level_id' => ['required'],
                    ],
                    [],
                    [
                        'payroll_languages.'.$i.'.payroll_lang_id' => 'idioma #'.($i+1),
                        'payroll_languages.'.$i.'.payroll_language_level_id' => 'nivel de idioma #'.($i+1),
                    ],
                );
                $payroll_lang = PayrollLanguage::find($payroll_language['payroll_lang_id']);
                $payroll_language_level = PayrollLanguageLevel::find($payroll_language['payroll_language_level_id']);
                $payrollProfessional->payrollLanguages()->attach(
                    $payroll_lang->id,
                    ['payroll_language_level_id' => $payroll_language_level->id]
                );
                $i++;
            }
            foreach ($payrollProfessional->professions as $profession) {
                $prof = Profession::find($profession['id']);
                $payrollProfessional->professions()->detach($prof);
            }

            foreach ($request->professions as $profession) {
                $prof = Profession::find($profession['id']);
                $payrollProfessional->professions()->attach($prof);
            }
        });
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('payroll.professionals.index')], 200);
    }

    /**
     * Elimina la información profesional del trabajador
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del dato a eliminar
     * @return \Illuminate\Http\JsonResponse    Json con mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $payrollProfessional = PayrollProfessional::find($id);
        $payrollProfessional->delete();
        return response()->json(['record' => $payrollProfessional, 'message' => 'Success'], 200);
    }

    /**
     * Muestra la información profesional del trabajador registrada
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de la información profesional
     */
    public function vueList()
    {
        return response()->json(['records' => PayrollProfessional::with([
            'payrollStaff', 'payrollInstructionDegree','professions',
            'payrollStudyType', 'payrollLanguages',
            'payrollClassSchedule' => function ($query) {
                $query->with('documents');
            },
        ])->get()], 200);
    }

    /**
     * Obtiene las profesiones sin usar template_choices
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de las profesiones
     */
    public function getJsonProfessions()
    {
        return response()->json(['jsonProfessions' => Profession::all()], 200);
    }
}
