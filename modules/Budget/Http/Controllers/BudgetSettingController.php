<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;

use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetSubSpecificFormulation;

class BudgetSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $projects = BudgetProject::all();
        $codeSettings = CodeSetting::where('module', 'budget')->get();
        $fCode = $codeSettings->where('table', 'budget_formulations')->first();
        $cCode = $codeSettings->where('table', 'budget_commitments')->first();
        $tCode = $codeSettings->where('table', 'budget_transfers')->first();
        $rCode = $codeSettings->where('table', 'budget_reductions')->first();
        $crCode = $codeSettings->where('table', 'budget_credits')->first();
        $caCode = $codeSettings->where('table', 'budget_caused')->first();
        $pCode = $codeSettings->where('table', 'budget_payed')->first();
        return view('budget::settings', compact(
            'projects', 'fCode', 'cCode', 'tCode', 'rCode', 'crCode', 'caCode', 'pCode'
        ));
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
            $model = '';

            if ($key !== '_token' && !is_null($value)) {
                list($table, $field) = explode("_", $key);
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);
                
                if ($table === "formulations") {
                    $model = BudgetSubSpecificFormulation::class;
                }
                else if ($table === "commitments") {
                    $model .= "Commitment";
                }
                else if ($table === "transfers") {
                    $model .= "Transfer";
                }
                else if ($table === "reductions") {
                    $model .= "Reduction";
                }
                else if ($table === "credits") {
                    $model .= "Credit";
                }

                CodeSetting::updateOrCreate([
                    'module' => 'budget',
                    'table' => 'budget_' . $table,
                    'field' => $field,
                ], [
                    'format_prefix' => $prefix,
                    'format_digits' => $digits,
                    'format_year' => $sufix,
                    'model' => $model,
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
