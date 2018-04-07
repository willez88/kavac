<?php

namespace App\Http\Controllers;

use App\Models\InstitutionType;
use Illuminate\Http\Request;

class InstitutionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => InstitutionType::all()], 200);
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
            'name' => 'required|max:100',
            'acronym' => 'max:10'
        ]);


        $institutionType = InstitutionType::create([
            'name' => $request->input('name'),
            'acronym' => ($request->input('acronym'))?$request->input('acronym'):null
        ]);

        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstitutionType $institutionType)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'acronym' => 'max:10'
        ]);
 
        $institutionType->name = $request->input('name');
        $institutionType->acronym = ($request->input('acronym'))?$request->input('acronym'):null;
        $institutionType->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionType $institutionType)
    {
        $institutionType->delete();
        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }
}
