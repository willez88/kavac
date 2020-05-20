<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceDepartment;

class CitizenServiceDepartmentController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => CitizenServiceDepartment::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);
        $citizenServiceDepartment = CitizenServiceDepartment::create([
            'name' => $request->name
        ]);
        return response()->json(['record' => $citizenServiceDepartment, 'message' => 'Success'], 200);
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
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $citizenServiceDepartment = CitizenServiceDepartment::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);
        $citizenServiceDepartment->name  = $request->name;
        $citizenServiceDepartment->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $citizenServiceDepartment = CitizenServiceDepartment::find($id);
        $citizenServiceDepartment->delete();
        return response()->json(['record' => $citizenServiceDepartment, 'message' => 'Success'], 200);
    }
    public function getCitizenServiceDepartments()
    {
        return template_choices('Modules\CitizenService\Models\CitizenServiceDepartment', 'name', [], true, null);
    }
}
