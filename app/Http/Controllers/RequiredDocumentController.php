<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\RequiredDocument;
use Illuminate\Http\Request;

class RequiredDocumentController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:estate.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:estate.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estate.delete', ['only' => 'destroy']);
        $this->middleware('permission:estate.list', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($model, $module = null)
    {
        return response()->json([
            'records' => RequiredDocument::where(['model' => $model, 'module' => $module])->get()
        ], 200);
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
    public function store(Request $request, $model, $module = null)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);


        $requiredDocument = RequiredDocument::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'module' => $module,
            'model' => $model
        ]);

        return response()->json(['record' => $requiredDocument, 'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequiredDocument  $requiredDocument
     * @return \Illuminate\Http\Response
     */
    public function show(RequiredDocument $requiredDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequiredDocument  $requiredDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(RequiredDocument $requiredDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequiredDocument  $requiredDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $model, $module, RequiredDocument $requiredDocument)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        $requiredDocument->name = $request->name;
        $requiredDocument->description = $request->description ?? null;
        $requiredDocument->model = $model;
        $requiredDocument->module = $module;
        $requiredDocument->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequiredDocument  $requiredDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy($model, $module, RequiredDocument $requiredDocument)
    {
        $requiredDocument->delete();
        return response()->json(['record' => $requiredDocument, 'message' => 'Success'], 200);
    }
}
