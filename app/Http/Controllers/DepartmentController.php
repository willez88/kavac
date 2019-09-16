<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

/**
 * @class DepartmentController
 * @brief Gestiona información de Departamentos
 *
 * Controlador para gestionar Departamentos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DepartmentController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Department::with(['parent', 'childrens'])->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'institution_id' => ['required']
        ]);

        $hierarchy = 0;

        if (!is_null($request->parent_id) || !empty($request->parent_id)) {
            $dto = Department::where('parent_id', $request->parent_id)->first();
            if ($dto) {
                $hierarchy = $dto->hierarchy + 1;
            }
        }

        $department = Department::create([
            'name' => $request->name,
            'acronym' => ($request->acronym)?$request->acronym:null,
            'hierarchy' => $hierarchy,
            'issue_requests' => $request->issue_requests ?? false,
            'active' => $request->active ?? false,
            'administrative' => $request->administrative ?? false,
            'parent_id' => ($request->parent_id)?$request->parent_id:null,
            'institution_id' => $request->institution_id
        ]);

        return response()->json(['record' => $department, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'name' => ['required'],
            'institution_id' => ['required']
        ]);

        $hierarchy = 0;

        if (!is_null($request->parent_id) || !empty($request->parent_id)) {
            $dto = Department::where('parent_id', $request->parent_id)->first();
            if ($dto) {
                $hierarchy = $dto->hierarchy + 1;
            }
        }

        $department->name = $request->name;
        $department->acronym = ($request->acronym)?$request->acronym:null;
        $department->hierarchy = $hierarchy;
        $department->issue_requests = $request->issue_requests ?? false;
        $department->active = $request->active ?? false;
        $department->administrative = $request->administrative ?? false;
        $department->parent_id = ($request->parent_id)?$request->parent_id:null;
        $department->institution_id = $request->institution_id;
        $department->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['record' => $department, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene un listado de departamentos
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request  $request        Objeto con los datos de la petición
     * @param  integer  $institution_id Identificador de la institución
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(Request $request, $institution_id)
    {
        return response()->json(
            template_choices(Department::class, 'name', ['institution_id' => $institution_id], true)
        );
    }
}
