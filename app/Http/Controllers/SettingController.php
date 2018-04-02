<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Institution;
use App\Models\Country;
use App\Models\Estate;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\City;
use App\Models\InstitutionSector;
use App\Models\InstitutionType;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model_setting = Setting::where('active', true)->first();
        $header_setting = [
            'route' => 'settings.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $model_institution = Institution::where('active', true)->where('default', true)->first();
        $header_institution = [
            'route' => 'institution.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
            'enctype' => 'multipart/form-data'
        ];
        $institutions = Institution::all();
        $countries = Country::template_choices();
        $estates = Estate::template_choices();
        $municipalities = Municipality::template_choices();
        $parishes = Parish::template_choices();
        $cities = City::template_choices();
        $sectors = InstitutionSector::template_choices();
        $types = InstitutionType::template_choices();

        return view(
            'admin.settings',
            compact(
                'model_setting', 'header_setting', 'model_institution', 'header_institution', 'institutions',
                'countries', 'estates', 'municipalities', 'parishes', 'cities', 'sectors', 'types'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = Setting::updateOrCreate(
            ['active' => true],
            [
                'support' => ($request->input('support')!==null),
                'chat' => ($request->input('chat')!==null),
                'notify' => ($request->input('notify')!==null),
                'report_banner' => ($request->input('report_banner')!==null),
                'multi_institution' => ($request->input('multi_institution')!==null),
                'digital_sign' => ($request->input('digital_sign')!==null)
            ]
        );
        
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('settings.index');
    }
}
