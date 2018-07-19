<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Payroll\Models\StaffType;

class StaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $staff_types = StaffType::all();
        //error_log($staff_types);
        return view('payroll::staff-types.index', compact('staff_types'));
        //return view('payroll::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header_staff_type = [
            'route' => 'staff-types.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-types.create', compact('header_staff_type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $staff_types = new StaffType;
        $staff_types->name  = $request->name;
        $staff_types->description = $request->description;

        $staff_types->save();

        return redirect()->route('staff-types.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $model_staff_type = StaffType::find($id);
        $header_staff_type = [
            'route' => ['staff-types.update', $model_staff_type->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::staff-types.edit', compact('model_staff_type','header_staff_type'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $staff_type = StaffType::find($id);

        $staff_type->name  = $request->name;
        $staff_type->description = $request->description;

        $staff_type->save();

        return redirect()->route('staff-types.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $staff_type = StaffType::find($id);
        $staff_type->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
