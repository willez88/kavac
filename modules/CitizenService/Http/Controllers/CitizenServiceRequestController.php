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
            'date'                  => ['required'],
            'first_name'            => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'last_name'             => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'id_number'             => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                 => ['required', 'email'],
            'city_id'               => ['required'],
            'parish_id'             => ['required'],
            'address'               => ['required', 'max:200'],
            'motive_request'        => ['required', 'max:200'],
            'attribute'             => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'date.required'         => 'El campo fecha es obligatorio.',
            'first_name.required'   => 'El campo nombres es obligatorio.',
            'first_name.max'        => 'El campo nombres no debe contener más de 100 caracteres.',
            'first_name.regex'      => 'El campo nombres no debe permitir números ni símbolos.',
            'last_name.required'    => 'El campo apellidos es obligatorio',
            'last_name.max'         => 'El campo apellidos no debe contener más de 100 caracteres.',
            'last_name.regex'       => 'El campo apellidos no debe permitir números ni símbolos.',
            'id_number.required'    => 'El campo cédula de identidad es obligatorio.',
            'id_number.max'         => 'El campo cédula de identidad no debe de contener más de 12 caracteres.',
            'id_number.regex'       => 'El campo cédula de identidad debe tener los caracteres.',
            'email.required'        => 'El campo correo electrónico es obligatorio. ',
            'email.email'           => 'El campo correo electrónico debe de ingresarse en formato de correo.',
            'city_id.required'           => 'El campo ciudad es obligatorio.',
            'parish_id.required'         => 'El campo parroquia es obligatorio.',
            'address.required'           => 'El campo dirección es obligatorio.',
            'address.max'                => 'El campo dirección no debe contener más de 200 caracteres.',
            'motive_request.required'    => 'El campo motivo de la solicitud es obligatorio.',
            'motive_request.max'         => 'El campo motivo de la solicitud no debe de contener más de 200 caracteres.',
            'attribute.required'         => 'El campo atributos es obligatorio.',
            'attribute.max'              => 'El campo atributos no debe de contener más de 200 caracteres.',
            'citizen_service_request_type_id.required'  => 'El campo tipo de solicitud es obligatorio.',
            'citizen_service_department_id.required'    => 'El campo dirección de departamento es obligatorio.',

            'inventory_code.required'  => 'El campo código de inventario es obligatorio.',
            'type_team.required'       => 'El campo tipo de equipo es obligatorio.',
            'brand.required'           => 'El campo marca es obligatorio.',
            'model.required'           => 'El campo modelo es obligatorio.',
            'serial.required'          => 'El campo serial es obligatorio.',
            'color.required'           => 'El campo color es obligatorio.',
            'transfer.required'        => 'El campo motivo de traslado es obligatorio.',
            'entryhour.required'       => 'El campo hora de entrada es obligatorio.',
            'informationteam.required' => 'El campo información adicional del equipo es obligatorio.',

            'institution_name.required'   => 'El campo nombre de la institución es obligatorio.',
            'institution_name.max'        => 'El campo nombre de la institución no debe de contener más de 200 caracteres.',
            'rif.required'                => 'El campo rif es obligatorio.',
            'rif.unique:citizen_service_requests,rif' => 'El campo rif debe de ser único.',
            'rif.size'                    => 'El campo rif no debe de contener más de 10 caracteres. ',
            'institution_address.required'   => 'El campo dirección de la institución es obligatorio.',
            'institution_address.max'        => 'El campo dirección de la institución no debe de contener más de 200 caracteres.',
            'web.max'                        => 'El campo dirección web no debe de contener más de 200 caracteres.',
        ];
    }
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

        $validateRules = $this->validateRules;
        if ($request->citizen_service_request_type_id == 1) {
            $validateRules = array_merge($validateRules, [
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
        } elseif ($request->citizen_service_request_type_id == 2
                || $request->citizen_service_request_type_id == 3 || $request->citizen_service_request_type_id == 4) {
            $validateRules = array_merge($validateRules, [
                'citizen_service_department_id'    => ['required'],
            ]);
        }


        if ($request->type_institution) {
            $validateRules = array_merge($validateRules, [
                'institution_name'              => ['required', 'max:200'],
                'rif' => ['required', 'unique:citizen_service_requests,rif', 'size:10', new RifRule],
                'institution_address'           => ['required', 'max:200'],
                'web'                           => ['max:200'],
            ]);
        }

        $this->validate($request, $validateRules, $this->messages);

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate(
                $request,
                [
                    'phones.'.$i.'.type' => ['required'],
                    'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                    'phones.'.$i.'.number' => ['required', 'digits:7'],
                    'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
                ],
                [],
                [
                    'phones.'.$i.'.type' => 'tipo #'.($i+1),
                    'phones.'.$i.'.area_code' => 'código de area #'.($i+1),
                    'phones.'.$i.'.number' => 'número #'.($i+1),
                    'phones.'.$i.'.extension' => 'extensión #'.($i+1),
                ]
            );
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
            'parish_id'                        => $request->parish_id,
            'address'                          => $request->address,
            'motive_request'                   => $request->motive_request,
            'attribute'                        => $request->attribute,
            'state'                            => 'Pendiente',
            'citizen_service_request_type_id'  => $request->citizen_service_request_type_id,
            'citizen_service_department_id'    => $request->citizen_service_department_id,

            'type_institution'                 => $request->type_institution ?? false,
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
        $validateRules = $this->validateRules;
        if ($request->citizen_service_request_type_id == 1) {
            $validateRules = array_merge($validateRules, [
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
        } elseif ($request->citizen_service_request_type_id == 2
                 || $request->citizen_service_request_type_id == 3 || $request->citizen_service_request_type_id == 4) {
            $validateRules = array_merge($validateRules, [
                'citizen_service_department_id'    => ['required'],
            ]);
        }

        if ($request->type_institution) {
            $validateRules = array_merge($validateRules, [
                'institution_name'              => ['required', 'max:200'],
                'rif' => ['required', 'unique:citizen_service_requests,rif', 'size:10', new RifRule],
                'institution_address'           => ['required', 'max:200'],
                'web'                           => ['max:200'],
            ]);

            $citizenServiceRequest->type_institution = $request->type_institution ?? false;
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

        $this->validate($request, $validateRules, $this->messages);

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate(
                $request,
                [
                    'phones.'.$i.'.type' => ['required'],
                    'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                    'phones.'.$i.'.number' => ['required', 'digits:7'],
                    'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
                ],
                [],
                [
                    'phones.'.$i.'.type' => 'tipo #'.($i+1),
                    'phones.'.$i.'.area_code' => 'código de area #'.($i+1),
                    'phones.'.$i.'.number' => 'número #'.($i+1),
                    'phones.'.$i.'.extension' => 'extensión #'.($i+1),
                ]
            );
            $i++;
        }

        $citizenServiceRequest->date                             = $request->date;
        $citizenServiceRequest->first_name                       = $request->first_name;
        $citizenServiceRequest->last_name                        = $request->last_name;
        $citizenServiceRequest->id_number                        = $request->id_number;
        $citizenServiceRequest->email                            = $request->email;
        $citizenServiceRequest->city_id                          = $request->city_id;
        $citizenServiceRequest->parish_id                        = $request->parish_id;
        $citizenServiceRequest->address                          = $request->address;
        $citizenServiceRequest->motive_request                   = $request->motive_request;
        $citizenServiceRequest->attribute                        = $request->attribute;
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

        foreach ($citizenServiceRequest->phones as $phone) {
            $phone->delete();
        }
        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $citizenServiceRequest->phones()->updateOrCreate(
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ],
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ]
                );
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
        return response()->json(['records' => CitizenServiceRequest::with(['city', 'parish'])->get()], 200);
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
