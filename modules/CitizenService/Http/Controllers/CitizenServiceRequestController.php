<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use App\Models\CodeSetting;
use App\Models\Phone;
use App\Rules\Rif as RifRule;

class CitizenServiceRequestController extends Controller
{
    use ValidatesRequests;

    /**
     * Muestra un listado de las solicitudes de atención al ciudadano
     * @return Renderable
     */
    public function index()
    {
        return view('citizenservice::requests.list');
    }

    /**
     * Muestra el formulario para registrar una nueva solicitud
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::requests.create');
    }

    /**
     * Valida y registra una nueva solicitud de atención al ciudadano
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'                             => ['required'],
            'first_name'                       => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'last_name'                        => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'id_number'                        => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                            => ['required', 'email'],
            'city_id'                          => ['required'],
            'municipality_id'                  => ['required'],
            'address'                          => ['required', 'max:200'],
            'motive_request'                   => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],

        ]);



        $requestType = $request->citizen_service_request_type_id;
        if ($requestType == 1) {
            $this->validate($request, [
                'inventory_code'  => ['required'],
                'type_team'       => ['required'],
                'brand'           => ['required'],
                'model'           => ['required'],
                'serial'          => ['required'],
                'color'           => ['required'],
                'transfer'        => ['required'],
                'entryhour'       => ['required'],
                'informationteam' => ['required'],

            ]);
        }
        if ($requestType ==2 || $requestType ==3 || $requestType ==4) {
            $this->validate($request, [
                'citizen_service_department_id'    => ['required'],

            ]);
        }


        if ($request->type_institution) {
            $this->validate($request, [
                'institution_name'              => ['required', 'max:200'],
                'rif' => ['required', 'unique:citizen_service_requests,rif', 'size:10', new RifRule],
                'institution_address'           => ['required', 'max:200'],
                'web'                           => ['max:200'],
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

        $codeSetting = CodeSetting::where('table', 'citizen_service_requests')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('citizenservice.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );



        //Guardar los registros del formulario en  CitizenServiceRequest
        $citizenServiceRequest = CitizenServiceRequest::create([
            'file_counter'                     => 0,
            'code'                             => $code,
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
            'citizen_service_department_id'    => $request->citizen_service_department_id,

            'type_institution'                 =>$request->type_institution,
            'institution_name'                 => $request->institution_name,
            'rif'                              => $request->rif,
            'institution_address'              => $request->institution_address,
            'web'                              => $request->web,

            'inventory_code'                   => $request->inventory_code,
            'type_team'                        => $request->type_team,
            'brand'                            => $request->brand,
            'model'                            => $request->model,
            'serial'                           => $request->serial,
            'color'                            => $request->color,
            'transfer'                         => $request->transfer,
            'entryhour'                        => $request->entryhour,
            'exithour'                         => $request->exithour,
            'informationteam'                  => $request->informationteam,

        ]);


        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $citizenServiceRequest->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }
        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.request.index')], 200);
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
     * Muestra el formulario para actualizar la información de las solicitudes de atención al ciudadano
     * @return Renderable
     */
    public function edit($id)
    {
        $request = CitizenServiceRequest::find($id);
        return view('citizenservice::requests.create', compact('request'));
    }

    /**
     * Actualiza la información de las solicitudes de atención al ciudadano
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        $this->validate($request, [
            'date'                             => ['required'],
            'first_name'                       => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'last_name'                        => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'id_number'                        => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                            => ['required', 'email'],
            'city_id'                          => ['required'],
            'municipality_id'                  => ['required'],
            'address'                          => ['required', 'max:200'],
            'motive_request'                   => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],
            'citizen_service_department_id'    => ['required'],

        ]);



        if ($request->citizen_service_request_type_id == 1) {
            $this->validate($request, [
                'inventory_code'                   => ['required'],
                'type_team'                        => ['required'],
                'brand'                            => ['required'],
                'model'                            => ['required'],
                'serial'                           => ['required'],
                'color'                            => ['required'],
                'transfer'                         => ['required'],
                'entryhour'                        => ['required'],
                'exithour'                         => ['required'],
                'informationteam'                  => ['required'],
            ]);
        }



        if ($request->type_institution) {
            $this->validate($request, [
                'institution_name'              => ['required', 'max:200'],
                'rif' => ['required', 'unique:citizen_service_requests,rif,'.$citizenServiceRequest->id,
                          'size:10', new RifRule],
                'institution_address'           => ['required', 'max:200'],
                'web'                           => ['max:200'],
            ]);
            $citizenServiceRequest->type_institution = $request->type_institution;
            $citizenServiceRequest->institution_name = $request->institution_name;
            $citizenServiceRequest->rif = $request->rif;
            $citizenServiceRequest->institution_address = $request->institution_address;
            $citizenServiceRequest->web = $request->web;
        } else {
            $citizenServiceRequest->type_institution = false;
            $citizenServiceRequest->institution_name = null;
            $citizenServiceRequest->rif = null;
            $citizenServiceRequest->institution_address = null;
            $citizenServiceRequest->web = null;
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
        $citizenServiceRequest->citizen_service_department_id    = $request->citizen_service_department_id;


        $citizenServiceRequest->inventory_code                   = $request->inventory_code;
        $citizenServiceRequest->type_team                        = $request->type_team;
        $citizenServiceRequest->brand                            = $request->brand;
        $citizenServiceRequest->model                            = $request->model;
        $citizenServiceRequest->serial                           = $request->serial;
        $citizenServiceRequest->color                            = $request->color;
        $citizenServiceRequest->transfer                         = $request->transfer;
        $citizenServiceRequest->entryhour                        = $request->entryhour;
        $citizenServiceRequest->exithour                         = $request->exithour;
        $citizenServiceRequest->informationteam                  = $request->informationteam;
        $citizenServiceRequest->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $citizenServiceRequest->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.request.index')], 200);
    }

    /**
     * Elimina una solicitud de atención al ciudadano
     * @return JsonResponse
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
        return response()->json(['records' => CitizenServiceRequest::with(['city', 'municipality'])->get()], 200);
    }

    public function vueInfo($id)
    {
        $citizenServiceRequest = CitizenServiceRequest::where('id', $id)->with([
            'phones','citizenServiceDepartment', 'citizenServiceRequestType'
        ])->first();
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
