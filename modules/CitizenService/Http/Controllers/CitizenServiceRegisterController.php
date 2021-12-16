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
            'date_register'     => ['required'],
            'payroll_staff_id'  => ['required'],
            'project_name'  => ['required', 'max:100'],
            'team_name'     => ['required', 'max:200'],
            'activities'    => ['required', 'max:100'],
            'start_date'    => ['required','date'],
            'end_date'      => ['required','after_or_equal:start_date'],
            'email'         => ['required', 'email'],
            'percent'       => ['integer', 'min:1', 'max:100']

        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'payroll_staff_id.required'   => 'El campo nombre del director es obligatorio.',
            'project_name.required'   => 'El campo nombre del proyecto es obligatorio',
            'project_name.max'        => 'El campo nombre del proyecto no debe contener más de 100 caracteres.',
            'team_name.required'      => 'El campo equipo responsable es obligatorio',
            'team_name.max'           => 'El campo equipo responsable no debe contener más de 200 caracteres.',
            'activities.required'     => 'El campo actividades es obligatorio',
            'activities.max'          => 'El campo actividades no debe contener más de 100 caracteres.',
            'start_date.required'     => 'El campo fecha de inicio es obligatorio',
            'end_date.required'       => 'El campo fecha de culminación es obligatorio',
            'end_date.after_or_equal' => 'La fecha de culminación debe ser una fecha posterior o igual a la fecha de inicio',
            'email.required'          => 'El campo correo electrónico es obligatorio',
            'email.email'             => 'El campo correo electrónico es de tipo email',
            'percent.max'             => 'El campo porcentaje de cumplimiento no debe contener más de 100 caracteres.',
            'percent.integer'         => 'El campo porcentaje de cumpliento debe ser entero',
            'percent.min'             => 'El campo porcentaje de cumpliento número minimo es 1',
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

            'date_register'    => $request->input('date_register'),
            'payroll_staff_id' => $request->input('payroll_staff_id'),
            'project_name'     => $request->input('project_name'),
            'team_name'        => $request->input('team_name'),
            'activities'       => $request->input('activities'),
            'start_date'       => $request->input('start_date'),
            'end_date'         => $request->input('end_date'),
            'email'            => $request->input('email'),
            'percent'          => $request->input('percent')
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
    public function update(Request $request, $id)
    {


        $this->validate($request, $this->validateRules, $this->messages);
        $citizenServiceRegister = CitizenServiceRegister::find($id);
        $citizenServiceRegister->date_register         = $request->date_register;
        $citizenServiceRegister->payroll_staff_id      = $request->payroll_staff_id;
        $citizenServiceRegister->project_name          = $request->project_name;
        $citizenServiceRegister->team_name             = $request->team_name;
        $citizenServiceRegister->activities            = $request->activities;
        $citizenServiceRegister->start_date            = $request->start_date;
        $citizenServiceRegister->end_date              = $request->end_date;
        $citizenServiceRegister->email                 = $request->email;
        $citizenServiceRegister->percent               = $request->percent;
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
