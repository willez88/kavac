<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => MaritalStatus::all()], 200);
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
            'name' => 'required|max:100'
        ]);

        $maritalStatus = MaritalStatus::create(['name' => $request->input('name')]);

        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function show(MaritalStatus $maritalStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(MaritalStatus $maritalStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaritalStatus $maritalStatus)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
 
        $maritalStatus->name = $request->input('name');
        $maritalStatus->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();
        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }
}
