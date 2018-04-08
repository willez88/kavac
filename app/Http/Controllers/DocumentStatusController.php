<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => DocumentStatus::all()], 200);
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
            'name' => 'required|max:20',
            'description' => 'required',
            'color' => 'required|min:4|max:30'
        ]);


        $documentStatus = DocumentStatus::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'color' => $request->input('color')
        ]);

        return response()->json(['record' => $documentStatus, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentStatus $documentStatus)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'description' => 'required',
            'color' => 'required|min:4|max:30'
        ]);
 
        $documentStatus->name = $request->input('name');
        $documentStatus->description = $request->input('description');
        $documentStatus->color = $request->input('color');
        $documentStatus->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentStatus $documentStatus)
    {
        $documentStatus->delete();
        return response()->json(['record' => $documentStatus, 'message' => 'Success'], 200);
    }
}
