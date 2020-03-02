<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use App\Models\Phone;

class CitizenServiceRequestController extends Controller
{
    use ValidatesRequests;

    /**
     * Muestra un listado de las solicitudes de atención al ciudadano
     * @return Response
     */
    public function index()
    {
        return view('citizenservice::requests.list');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     * @return Response
     */
    public function create()
    {
        return view('citizenservice::requests.create');
    }

    /**
     * Valida y registra una nueva solicitud de atención al ciudadano
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'                             => ['required'],
            'first_name'                       => ['required', 'max:100'],
            'last_name'                        => ['required', 'max:100'],
            'id_number'                        => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                            => ['required', 'email'],
            'city_id'                          => ['required'],
            'municipality_id'                  => ['required'],
            'address'                          => ['required', 'max:200'],
            'motive_request'                   => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],

        ]);

        if ($request->type_institution == true) {
            $this->validate($request, [
                'institution_name'                 => ['required', 'max:200'],
                'rif'                              => ['required', 'max:100'],
                'institution_address'              => ['required', 'max:200'],
                'web'                              => ['required', 'max:200'],
            ]);
        }

        if ($request->citizen_service_request_type_id == 1) {
            $this->validate($request, [
                'team'            => ['required'],
                'brand'           => ['required'],
                'model'           => ['required'],
                'serial'          => ['required'],
                'color'           => ['required'],
                'transfer'        => ['required'],
                'code'            => ['required'],
                'entryhour'       => ['required'],
                'exithour'        => ['required'],
                'informationteam' => ['required'],
            ]);
        }

        
       
        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => ['required'],
                'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                'phones.'.$i.'.number' => ['required', 'digits:7'],
                'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
            ]);
            $i++;
        }
       
        //Guardar los registros del formulario en  citizensrviceRequest
        $citizenserviceRequest = CitizenServiceRequest::create([
            'date'                             => $request->date,
            'first_name'                       => $request->first_name,
            'last_name'                        => $request->last_name,
            'id_number'                        => $request->id_number,
            'email'                            => $request->email,
            'city_id'                          => $request->city_id,
            'municipality_id'                  => $request->municipality_id,
            'address'                          => $request->address,
            'motive_request'                   => $request->motive_request,
            'state'                            => 'Pendiente',
            'citizen_service_request_type_id'  => $request->citizen_service_request_type_id,

            'institution_name'                 => $request->institution_name,
            'rif'                              => $request->rif,
            'institution_address'              => $request->institution_address,
            'web'                              => $request->web,

            'team'                             => $request->team,
            'brand'                            => $request->brand,
            'model'                            => $request->model,
            'serial'                           => $request->serial,
            'color'                            => $request->color,
            'transfer'                         => $request->transfer,
            'code'                             => $request->code,
            'entryhour'                        => $request->entryhour,
            'exithour'                         => $request->exithour,
            'informationteam'                  => $request->informationteam,
            
        ]);


        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $citizenserviceRequest->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Muestra el formulario para actualizar la información de las solicitudes de atención al ciudadano
     * @return Response
     */
    public function edit($id)
    {
        $request = CitizenServiceRequest::find($id);
        return view('citizenservice::requests.create', compact('request'));
    }

    /**
     * Actualiza la información de las solicitudes de atención al ciudadano
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        $this->validate($request, [
            'date'                             => ['required'],
            'first_name'                       => ['required', 'max:100'],
            'last_name'                        => ['required', 'max:100'],
            'id_number'                        => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                            => ['required', 'email'],
            'city_id'                          => ['required'],
            'municipality_id'                  => ['required'],
            'address'                          => ['required', 'max:200'],
            'motive_request'                   => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],

            'institution_name'                 => ['required', 'max:200'],
            'rif'                              => ['required', 'max:100'],
            'institution_address'              => ['required', 'max:200'],
            'web'                              => ['required', 'max:200'],
          
        ]);

        if ($request->citizen_service_request_type_id == 1) {
            $this->validate($request, [
                'team'                             => ['required'],
                'brand'                            => ['required'],
                'model'                            => ['required'],
                'serial'                           => ['required'],
                'color'                            => ['required'],
                'transfer'                         => ['required'],
                'code'                             => ['required'],
                'entryhour'                        => ['required'],
                'exithour'                         => ['required'],
                'informationteam'                  => ['required'],
            ]);
        }


        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => ['required'],
                'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                'phones.'.$i.'.number' => ['required', 'digits:7'],
                'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
            ]);
            $i++;
        }
        $citizenServiceRequest->date                             = $request->date;
        $citizenServiceRequest->first_name                       = $request->first_name;
        $citizenServiceRequest->last_name                        = $request->last_name;
        $citizenServiceRequest->id_number                        = $request->id_number;
        $citizenServiceRequest->email                            = $request->email;
        $citizenServiceRequest->city_id                          = $request->city_id;
        $citizenServiceRequest->municipality_id                  = $request->municipality_id;
        $citizenServiceRequest->address                          = $request->address;
        $citizenServiceRequest->motive_request                   = $request->motive_request;
        $citizenServiceRequest->state                            = 'Pendiente';
        $citizenServiceRequest->citizen_service_request_type_id  = $request->citizen_service_request_type_id;

        $citizenServiceRequest->institution_name                 = $request->institution_name;
        $citizenServiceRequest->rif                              = $request->rif;
        $citizenServiceRequest->institution_address              = $request->institution_address;
        $citizenServiceRequest->web                              = $request->web;


        $citizenServiceRequest->team                             = $request->team;
        $citizenServiceRequest->brand                            = $request->brand;
        $citizenServiceRequest->model                            = $request->model;
        $citizenServiceRequest->serial                           = $request->serial;
        $citizenServiceRequest->color                            = $request->color;
        $citizenServiceRequest->transfer                         = $request->transfer;
        $citizenServiceRequest->code                             = $request->code;
        $citizenServiceRequest->entryhour                        = $request->entryhour;
        $citizenServiceRequest->exithour                         = $request->exithour;
        $citizenServiceRequest->informationteam                  = $request->informationteam;
        $citizenServiceRequest->save();
    }

    /**
     * Elimina una solicitud de atención al ciudadano
     * @return Response
     */
    public function destroy(CitizenServiceRequest $request)
    {
        $request->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
    * Obtiene un listado de las solicitudes registradas


     */
    public function vueList()
    {
        return response()->json(['records' => CitizenServiceRequest::all()], 200);
    }

    public function vueInfo($id)
    {
        $citizenServiceRequest = CitizenServiceRequest::where('id', $id)->with('phones')->first();
        return response()->json(['record' => $citizenServiceRequest], 200);
    }
    public function vueListPending()
    {
        return response()->json(['records' => CitizenServiceRequest::where('state', 'Pendiente')->get()], 200);
    }
    public function vueListClosing()
    {
        $citizenServiceRequest = CitizenServiceRequest::where('state', 'Iniciado')->get();
        return response()->json(['records' => $citizenServiceRequest], 200);
    }
    public function vueClose($id)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        return response()->json(['record' => $citizenServiceRequest], 200);
    }
    public function vueCloseImageUpdate()
    {
        dd("entro");
    }
    public function approved(Request $request, $id)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        $citizenServiceRequest->state = 'Iniciado';

      
        $citizenServiceRequest->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.request.index')], 200);
    }


    public function rejected(Request $request, $id)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        $citizenServiceRequest->state = 'Rechazado';
      

        $citizenServiceRequest->save();
        
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.request.index')], 200);
    }
}
