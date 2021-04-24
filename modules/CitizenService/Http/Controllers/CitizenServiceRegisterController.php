<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRegister;
use Illuminate\Validation\Rule;

class CitizenServiceRegisterController extends Controller
{
    use ValidatesRequests;
    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;
    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'date_register' => ['required'],
            'first_name'    => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'project_name'  => ['required', 'max:100'],
            'activities'    => ['required', 'max:100'],
            'start_date'    => ['required','date'],
            'end_date'      => ['required','after_or_equal:start_date'],
            'email'         => ['required', 'email'],
            'percent'       => ['required', 'integer', 'min:1', 'max:100']

        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'first_name.required'   => 'El campo Nombre del director es obligatorio.',
            'first_name.max'        => 'El campo Nombre del director no debe contener más de 100 caracteres.',
            'first_name.regex'      => 'El campo Nombre del director no debe permitir números ni símbolos.',
            'project_name.required' => 'El campo Nombre del proyecto es obligatorio',
            'project_name.max'      => 'El campo Nombre del proyecto no debe contener más de 100 caracteres.',
            'activities.required'   => 'El campo Actividades es obligatorio',
            'activities.max'        => 'El campo Actividades no debe contener más de 100 caracteres.',
            'start_date.required'   => 'El campo Fecha de inicio es obligatorio',
            'end_date.required'     => 'El campo Fecha de culminación es obligatorio',
            'email.required'        => 'El campo Correo electrónico es obligatorio',
            'email.email'           => 'El campo Correo electrónico es de tipo email',
            'percent.required'      => 'El campo Porcentaje de cumplimiento es obligatorio',
            'percent.max'           => 'El campo Porcentaje de cumplimiento no debe contener más de 100 caracteres.'
        ];
    }

    public function index()
    {
        return view('citizenservice::registers.list');
    }

    /**
     * Muestra el formulario para registrar un cronograma de
     * actividades
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::registers.create');
    }

    /**
     * Valida y registra un nuevo cronograma de actividades
     * @param  Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        //Guardar los registros del formulario en  CitizenServiceRegister
        $citizenserviceRegister = CitizenServiceRegister::create([

            'date_register' => $request->input('date_register'),
            'first_name'    => $request->input('first_name'),
            'project_name'  => $request->input('project_name'),
            'activities'    => $request->input('activities'),
            'start_date'    => $request->input('start_date'),
            'end_date'      => $request->input('end_date'),
            'email'         => $request->input('email'),
            'percent'       => $request->input('percent')
        ]);

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.register.index')], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Muestra el formulario para actualizar la información
     * @return Renderable
     */
    public function edit($id)
    {
        $request = CitizenServiceRegister::find($id);
        return view('citizenservice::registers.create', compact('request'));
    }

    /**
     * Actualiza un registro de actividades
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, CitizenServiceRegister $citizenServiceRegister)
    {
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'
            ->ignore($citizenServiceRegister->id)]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $citizenServiceRegister->date_register         = $request->input('date_register');
        $citizenServiceRegister->first_name            = $request->input('first_name');
        $citizenServiceRegister->project_name          = $request->input('project_name');
        $citizenServiceRegister->activities            = $request->input('activities');
        $citizenServiceRegister->start_date            = $request->input('start_date');
        $citizenServiceRegister->end_date              = $request->input('end_date');
        $citizenServiceRegister->email                 = $request->input('email');
        $citizenServiceRegister->percent               = $request->input('percent');
        $citizenServiceRegister->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.register.index')], 200);
    }


    /**
     * Elimina un registro de actividad
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $citizenServiceRegister = CitizenServiceRegister::find($id);
        $citizenServiceRegister->delete();
        return response()->json(['record' => $citizenServiceRegister,
             'message' => 'destroy'], 200);
    }


    /*
    * Obtiene un listado de los registros de actividades
    */
    public function vueList()
    {
        return response()->json(['records' => CitizenServiceRegister::all()], 200);
    }

    /*
    * Obtiene la información de un registro de actividad registrado
    */
    public function vueInfo($id)
    {
        $citizenServiceRegister = CitizenServiceRegister::where('id', $id)
            ->first();
        return response()->json(['record' => $citizenServiceRegister], 200);
    }
}
