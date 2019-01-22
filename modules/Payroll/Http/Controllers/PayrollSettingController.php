<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Models\CodeSetting;
use Modules\Payroll\Models\PayrollStaff;

class PayrollSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $codeSettings = CodeSetting::where('module', 'payroll')->get();
        $sCode = $codeSettings->where('table', 'payroll_staffs')->first();
        return view('payroll::settings', compact('codeSettings', 'sCode'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //return view('budget::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $staffs_code = $request->staffs_code;
        $model = PayrollStaff::class;
        list($prefix, $digits, $sufix) = CodeSetting::divideCode($staffs_code);
        CodeSetting::updateOrCreate([
            'module' => 'payroll',
            'table' => 'payroll_staffs',
            'field' => 'code',
        ], [
            'format_prefix' => $prefix,
            'format_digits' => $digits,
            'format_year' => $sufix,
            'model' => $model,
        ]);

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
