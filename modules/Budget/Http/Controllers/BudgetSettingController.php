<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;

class BudgetSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('budget::settings');
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
        $codes = $request->input();
        $saved = false;

        foreach ($codes as $key => $value) {
            if ($key !== '_token' && !is_null($value)) {
                list($table, $field) = explode("_", $key);
                
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);
                CodeSetting::codeNextValue('budget_' . $table, $field, 'Modules\Budget\Models\BudgetAccount');
                CodeSetting::updateOrCreate([
                    'module' => 'budget',
                    'table' => 'budget_' . $table,
                    'field' => $field,
                    'format_prefix' => $prefix,
                    'format_digits' => $digits,
                    'format_year' => $sufix,
                ], [
                    'model' => 'Modules\Budget\Models\BudgetAccount',
                ]);

                $saved = true;
            }
        }
        
        if ($saved) {
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
