<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;
use Modules\Finance\Models\FinanceCheck;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('finance::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'checks_code' => [new CodeSettingRule]
        ]);

        list($prefix, $digits, $sufix) = CodeSetting::divideCode($request->checks_code);

        CodeSetting::updateOrCreate([
            'module' => 'finance',
            'table' => 'finance_checks',
            'field' => 'code',
            'type' => (isset($type)) ? $type : null
        ], [
            'format_prefix' => $prefix,
            'format_digits' => $digits,
            'format_year' => $sufix,
            'model' => FinanceCheck::class,
        ]);

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('finance::edit');
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

    public function setting()
    {
        $checkCode = '';
        return view('finance::settings', compact('checkCode'));
    }
}
