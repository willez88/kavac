<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequestType;
use Illuminate\Validation\Rule;

class CitizenServiceRequestTypeController extends Controller
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
            'name'        => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100'],
            'description' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:200'],
            'requirement' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:300']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'         => 'El campo nombre es obligatorio.',
            'name.max'              => 'El campo nombre no debe contener más de 100 caracteres.',
            'name.regex'            => 'El campo nombre no debe permitir números ni símbolos.',
            'description.required'  => 'El campo descripción es obligatorio',
            'description.max'       => 'El campo descripción no debe contener más de 100 caracteres.',
            'description.regex'     => 'El campo descripción no debe permitir números ni símbolos.',
            'requirement.required'  => 'El campo requerimientos de solicitud es obligatorio',
            'requirement.max'       => 'El campo requerimientos de solicitud no debe contener más de 100 caracteres.',
            'requirement.regex'     => 'El campo requerimientos de solicitud no debe permitir números ni símbolos.'
        ];
    }
    /**
      * Define la configuración de la clase
      *
      * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
      */
    public function index()
    {
        return response()->json(['records' => CitizenServiceRequestType::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Valida y registra un nuevo tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        //Guardar los registros del formulario en  CitizenServiceRequestType
        $citizenserviceRequestType = CitizenServiceRequestType::create([

            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'requirement'   => $request->input('requirement'),
        ]);

        return response()->json(['record' => $citizenserviceRequestType, 'message' => 'Success'], 200);
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
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Actualiza la información del tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $citizenserviceRequestType = CitizenServiceRequestType::find($id);
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100' . $citizenserviceRequestType->id]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $citizenserviceRequestType->name          = $request->name;
        $citizenserviceRequestType->description   = $request->description;
        $citizenserviceRequestType->requirement   = $request->requirement;
        $citizenserviceRequestType->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $citizenserviceRequestType = CitizenServiceRequestType::find($id);
        $citizenserviceRequestType->delete();
        return response()->json(['record' => $citizenserviceRequestType, 'message' => 'Success'], 200);
    }

    public function getRequestTypes()
    {
        return template_choices('Modules\CitizenService\Models\CitizenServiceRequestType', 'name', [], true, null);
    }
}
