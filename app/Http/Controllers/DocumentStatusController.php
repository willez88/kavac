<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:document.status.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:document.status.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:document.status.delete', ['only' => 'destroy']);
        $this->middleware('permission:document.status.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de estatus de documentos
     * 
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => DocumentStatus::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de estatus de documentos
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo estatus de documento
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20|unique:document_status,name',
            'description' => 'required',
            'color' => 'required|min:4|max:30|unique:document_status,color'
        ]);


        $documentStatus = DocumentStatus::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'color' => $request->input('color')
        ]);

        return response()->json(['record' => $documentStatus, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del estatus de documento
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un estatus de documento
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Actualiza la información del estatus de documento
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentStatus $documentStatus)
    {
        $this->validate($request, [
            'name' => 'required|max:20|unique:document_status,name,' . $documentStatus->id,
            'description' => 'required',
            'color' => 'required|min:4|max:30|unique:document_status,color,' . $documentStatus->id
        ]);
 
        $documentStatus->name = $request->input('name');
        $documentStatus->description = $request->input('description');
        $documentStatus->color = $request->input('color');
        $documentStatus->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el estatus de documento
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\DocumentStatus  $documentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentStatus $documentStatus)
    {
        $documentStatus->delete();
        return response()->json(['record' => $documentStatus, 'message' => 'Success'], 200);
    }
}
