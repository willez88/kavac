<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRegister;

class CitizenServiceRegisterController extends Controller
{
    use ValidatesRequests;
    /**
     * Muestra un listado de registos de actividades
     * @return Renderable
     */
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
        $this->validate($request, [
            'date_register' => ['required'],
            'first_name'    => ['required', 'max:100'],
            'project_name'  => ['required', 'max:100'],
            'activities'    => ['required', 'max:100'],
            'start_date'    => ['required'],
            'end_date'      => ['required'],
            'email'         => ['required', 'email'],
            'percent'       => ['required', 'max:10']
        ]);

        //Guardar los registros del formulario en  CitizenServiceRegister
        $citizenserviceRegister = CitizenServiceRegister::create([
            'date_register' => $request->date_register,
            'first_name'    => $request->first_name,
            'project_name'  => $request->project_name,
            'activities'    => $request->activities,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'email'         => $request->email,
            'percent'       => $request->percent
        ]);
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
        $citizenServiceRegister = CitizenServiceRegister::find($id);
        $this->validate($request, [
            'date_register'              => ['required'],
            'first_name'                 => ['required', 'max:100'],
            'project_name'               => ['required', 'max:100'],
            'activities'                 => ['required', 'max:100'],
            'start_date'                 => ['required'],
            'end_date'                   => ['required'],
            'email'                      => ['required', 'email'],
            'percent'                    => ['required', 'max:10'],

        ]);

        $citizenServiceRegister->date_register         = $request->date_register;
        $citizenServiceRegister->first_name            = $request->first_name;
        $citizenServiceRegister->project_name          = $request->project_name;
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
