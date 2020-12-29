<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollPermissionPolicy;

class PayrollPermissionPolicyController extends Controller
{
    use ValidatesRequests;
    /**
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return response()->json(['records' => PayrollPermissionPolicy::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payroll::create');
    }

    /**
     *
     * Valida y registra un nuevo tipo de permiso
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'             => ['required', 'max:100'],
            'anticipation_day' => ['required'],
            'day_min'          => ['required'],
            'day_max'          => ['required'],
        ]);
        $payrollPermissionPolicy = PayrollPermissionPolicy::create([
            'name'             => $request->name,
            'anticipation_day' => $request->anticipation_day,
            'day_min'    => $request->day_min,
            'day_max'    => $request->day_max
        ]);
        return response()->json(['record' => $payrollPermissionPolicy, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payroll::edit');
    }

    /**
     * Actualiza la información del tipo de permiso
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $payrollPermissionPolicy = PayrollPermissionPolicy::find($id);
        $this->validate($request, [
            'name'             => ['required', 'max:100'],
            'anticipation_day' => ['required'],
            'day_min'          => ['required'],
            'day_max'          => ['required']
        ]);
        $payrollPermissionPolicy->name             = $request->name;
        $payrollPermissionPolicy->anticipation_day = $request->anticipation_day;
        $payrollPermissionPolicy->day_min    = $request->day_min;
        $payrollPermissionPolicy->day_max    = $request->day_max;
        $payrollPermissionPolicy->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de permiso
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
   
    public function destroy($id)
    {
        $payrollPermissionPolicy = PayrollPermissionPolicy::find($id);
        $payrollPermissionPolicy->delete();
        return response()->json(['record' => $payrollPermissionPolicy, 'message' => 'Success'], 200);
    }
   
    public function getPermissionPolicies()
    {
        return template_choices('Modules\Payroll\Models\PayrollPermissionPolicy', 'name', [], true, null);
    }
}
