<?php

namespace App\Http\Controllers;

use App\Models\InstitutionSector;
use Illuminate\Http\Request;

class InstitutionSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => InstitutionSector::all()], 200);
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
        ]);


        $institutionSector = InstitutionSector::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'record' => $institutionSector,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstitutionSector $institutionSector)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);
 
        $institutionSector->name = $request->input('name');
        $institutionSector->save();
 
        return response()->json([
            'message' => 'Registro actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionSector $institutionSector)
    {
        $institutionSector->delete();
        return response()->json([
            'record' => $institutionSector,
            'message' => 'Success'
        ], 200);
    }
}
