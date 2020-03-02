<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CodeSetting;
use Modules\Payroll\Models\PayrollStaff;
use App\Rules\CodeSetting as CodeSettingRule;
use Modules\Payroll\Models\Parameter;

//use \Modules\Payroll\Models\PayrollWorkAgeSetting;

class PayrollSettingController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $codeSettings = CodeSetting::where('module', 'payroll')->get();
        $sCode = $codeSettings->where('table', 'payroll_staffs')->first();
        $parameter = Parameter::where([
            'active' => true, 'required_by' => 'payroll', 'p_key' => 'work_age'
        ])->first();
        return view('payroll::settings', compact('codeSettings', 'sCode', 'parameter'));
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
        $this->validate($request, [
            'staffs_code' => [new CodeSettingRule]
        ]);

        $staffsCode = $request->staffs_code;
        if (!is_null($staffsCode)) {
            $model = PayrollStaff::class;
            list($prefix, $digits, $sufix) = CodeSetting::divideCode($staffsCode);
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
            $request->session()->flash('message', ['type' => 'store']);
        }

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
