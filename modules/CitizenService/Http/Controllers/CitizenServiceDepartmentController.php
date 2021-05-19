<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceDepartment;

class CitizenServiceDepartmentController extends Controller
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
            'description' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:200']
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'name.required'         => 'El campo nombre es obligatorio.',
            'name.max'              => 'El campo nombre no debe contener más de 100 caracteres.',
            'name.regex'            => 'El campo nombre no debe permitir números ni símbolos.',
            'description.required'  => 'El campo descripción es obligatorio',
            'description.max'       => 'El campo descripción no debe contener más de 100 caracteres.',
            'description.regex'     => 'El campo descripción no debe permitir números ni símbolos.',
        ];
    }
    public function index()
    {
        return response()->json(['records' => CitizenServiceDepartment::all()], 200);
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
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        //Guardar los registros del formulario en  CitizenServiceDepartment
        $citizenServiceDepartment = CitizenServiceDepartment::create([

            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
        ]);

        return response()->json(['record' => $citizenServiceDepartment, 'message' => 'Success'], 200);
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $citizenServiceDepartment = CitizenServiceDepartment::find($id);
        $validateRules  = $this->validateRules;
        $validateRules  = array_replace(
            $validateRules,
            ['name' => ['required', 'regex:/^[\D][a-zA-ZÁ-ÿ0-9\s]*/u', 'max:100' . $citizenServiceDepartment->id]]
        );
        $this->validate($request, $validateRules, $this->messages);

        $citizenServiceDepartment->name          = $request->name;
        $citizenServiceDepartment->description   = $request->description;

        $citizenServiceDepartment->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $citizenServiceDepartment = CitizenServiceDepartment::find($id);
        $citizenServiceDepartment->delete();
        return response()->json(['record' => $citizenServiceDepartment, 'message' => 'Success'], 200);
    }

    public function getDepartments()
    {
        return template_choices('Modules\CitizenService\Models\CitizenServiceDepartment', 'name', [], true, null);
    }
}
