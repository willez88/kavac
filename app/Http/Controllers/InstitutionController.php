<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'onapre_code' => 'required|max:20',
            'rif' => 'required|max:10',
            'acronym' => 'required|max:100',
            'name' => 'required|max:100',
            'business_name' => 'required|max:100',
            'start_operations_date' => 'required|date',
            'legal_address' => 'required',
            'postal_code' => 'required|max:10',
            'institution_sector_id' => 'required',
            'institution_type_id' => 'required',
            'municipality_id' => 'required',
            'city_id' => 'required'
        ]);

        $institution = Institution::updateOrCreate(
            ['active' => true, 'default' => true],
            [
                'onapre_code' => $request->input('onapre_code'),
                'rif' => $request->input('rif'),
                'acronym' => $request->input('acronym'),
                'name' => $request->input('name'),
                'business_name' => $request->input('business_name'),
                'start_operations_date' => $request->input('start_operations_date'),
                'legal_address' => $request->input('legal_address'),
                'postal_code' => $request->input('postal_code'),
                'institution_sector_id' => $request->input('institution_sector_id'),
                'institution_type_id' => $request->input('institution_type_id'),
                'municipality_id' => $request->input('municipality_id'),
                'city_id' => $request->input('city_id'),
                'default' => true,
                'active' => ($request->input('active')!==null),
                'legal_base' => ($request->input('legal_base'))?$request->input('legal_base'):null,
                'legal_form' => ($request->input('legal_form'))?$request->input('legal_form'):null,
                'main_activity' => ($request->input('main_activity'))?$request->input('main_activity'):null,
                'mission' => ($request->input('mission'))?$request->input('mission'):null,
                'vision' => ($request->input('vision'))?$request->input('vision'):null,
                'web' => ($request->input('web'))?$request->input('web'):null,
                'composition_assets' => ($request->input('composition_assets'))?$request->input('composition_assets'):null,
                'retention_agent' => ($request->input('retention_agent')!==null),
                'logo_id' => ($request->input('logo_id'))?$request->input('logo_id'):null,
                'banner_id' => ($request->input('banner_id'))?$request->input('banner_id'):null,
            ]
        );

        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institution $institution)
    {
        //
    }
}
