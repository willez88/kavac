<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Rules\CodeSetting as CodeSettingRule;
use App\Models\CodeSetting;
use Modules\Payroll\Models\Parameter;

class PayrollSettingController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $enable = isModuleEnabled('DigitalSignature');
        $codeSettings = CodeSetting::where('module', 'payroll')->get();
        $sCode  = $codeSettings->where('table', 'payroll_staffs')->first();
        $ssCode = $codeSettings->where('table', 'payroll_salary_scales')->first();
        $stCode = $codeSettings->where('table', 'payroll_salary_tabulators')->first();
        $vRCode = $codeSettings->where('table', 'payroll_vacation_requests')->first();
        $bRCode = $codeSettings->where('table', 'payroll_benefits_requests')->first();
        $parameter = Parameter::where([
            'active' => true, 'required_by' => 'payroll', 'p_key' => 'work_age'
        ])->first();
        return view(
            'payroll::settings',
            compact('codeSettings', 'sCode', 'ssCode', 'stCode', 'vRCode', 'bRCode', 'parameter', 'enable')
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //return view('budget::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Redirect
     */
    public function store(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $this->validate($request, [
            'staffs_code'            => [new CodeSettingRule],
            'salary_scales_code'     => [new CodeSettingRule],
            'salary_tabulators_code' => [new CodeSettingRule],
            'vacation_requests_code' => [new CodeSettingRule],
            'benefits_requests_code' => [new CodeSettingRule]
        ]);

        /** @var array Arreglo con información de los campos de códigos configurados */
        $codes = $request->input();
        /** @var boolean Define el estatus falso para indicar que no se ha registrado información */
        $saved = false;

        foreach ($codes as $key => $value) {
            /** @var string Define el campo model a emplear en la generación del código */
            $model = '';

            if ($key !== '_token' && !is_null($value)) {
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);
                /** @var string Define el campo field */
                $field = "code";

                if ($key === "staffs_code") {
                    /** @var string Define el campo model para asociarlo al personal */
                    $model = \Modules\Payroll\Models\PayrollStaff::class;
                    /** @var string Define el campo table para asociarlo al personal */
                    $table = "staffs";
                } elseif ($key === "salary_scales_code") {
                    /** @var string Define el campo model para asociarlo a los escalafones salariales */
                    $model = \Modules\Payroll\Models\PayrollSalaryScale::class;
                    /** @var string Define el campo table para asociarlo a los escalafones salariales */
                    $table = "salary_scales";
                } elseif ($key === "salary_tabulators_code") {
                    /** @var string Define el campo model para asociarlo a los tabuladores salariales */
                    $model = \Modules\Payroll\Models\PayrollSalaryTabulator::class;
                    /** @var string Define el campo table para asociarlo a los tabuladores salariales */
                    $table = "salary_tabulators";
                } elseif ($key === "vacation_requests_code") {
                    /** @var string Define el campo model para asociarlo a las solicitudes de vacaciones */
                    $model = \Modules\Payroll\Models\PayrollVacationRequest::class;
                    /** @var string Define el campo table para asociarlo a las solicitudes de vacaciones */
                    $table = "vacation_requests";
                } elseif ($key === "benefits_requests_code") {
                    /** @var string Define el campo model para asociarlo a las solicitudes de prestaciones */
                    $model = \Modules\Payroll\Models\PayrollBenefitsRequest::class;
                    /** @var string Define el campo table para asociarlo a las solicitudes de prestaciones */
                    $table = "benefits_requests";
                }

                CodeSetting::updateOrCreate([
                    'module' => 'payroll',
                    'table'  => 'payroll_' . $table,
                    'field'  => $field,
                ], [
                    'format_prefix' => $prefix,
                    'format_digits' => $digits,
                    'format_year'   => $sufix,
                    'model'         => $model,
                ]);

                /** @var boolean Define el estatus verdadero para indicar que se ha registrado información */
                $saved = true;
            }
        }
        if ($saved) {
            $request->session()->flash('message', ['type' => 'store']);
        }

        return redirect()->back();
    }
}
