<?php

namespace App\Http\Controllers;

use App\Models\InstitutionType;
use Illuminate\Http\Request;

class InstitutionTypeController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:institution.type.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:institution.type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:institution.type.delete', ['only' => 'destroy']);
        $this->middleware('permission:institution.type.list', ['only' => 'index']);
    }
    
    /**
     * Muesta todos los registros de los tipos de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => InstitutionType::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * Muestra información acerca del tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Actualiza la información del tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
     * Elimina el tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionType $institutionType)
    {
        $institutionType->delete();
        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }
}
