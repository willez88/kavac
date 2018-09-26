<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct() {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => Department::with(['institution', 'parent'])->get()], 200);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'institution_id' => 'required'
        ]);

        $hierarchy = 0;

        if (!is_null($request->input('department_id')) || !empty($request->input('department_id'))) {
            $dto = Department::where('department_id', $request->input('department_id'))->first();
            if ($dto) {
                $hierarchy = $dto->hierarchy + 1;
            }
        }

        $department = Department::create([
            'name' => $request->input('name'),
            'acronym' => ($request->input('acronym'))?$request->input('acronym'):null,
            'hierarchy' => $hierarchy,
            'issue_requests' => (!is_null($request->input('issue_requests'))),
            'active' => (!is_null($request->input('active'))),
            'administrative' => (!is_null($request->input('administrative'))),
            'parent_id' => ($request->input('department_id'))?$request->input('department_id'):null,
            'institution_id' => $request->input('institution_id')
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }

    public function getDepartments(Request $request, $institution_id)
    {
        //foreach (Department::where('institution_id', $institution_id)->get() as $department) {
        foreach (Department::all() as $department) {
            $this->data[] = [
                'id' => $department->id,
                'text' => $department->name
            ];
        }

        return response()->json($this->data);
    }
}
