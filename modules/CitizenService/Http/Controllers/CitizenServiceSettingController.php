<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

class CitizenServiceSettingController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $codeSettings = CodeSetting::where('module', 'citizenservice')->get();
        $sCode = $codeSettings->where('table', 'citizen_service_requests')->first();
        return view('citizenservice::settings', compact('codeSettings', 'sCode'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'request_code' => [new CodeSettingRule]
        ]);

        $requestCode = $request->request_code;
        if (!is_null($requestCode)) {
            $model = CitizenServiceRequest::class;
            list($prefix, $digits, $sufix) = CodeSetting::divideCode($requestCode);
            CodeSetting::updateOrCreate([
                'module' => 'citizenservice',
                'table' => 'citizen_service_requests',
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
     * @return Renderable
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy()
    {
    }
}
