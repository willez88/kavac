<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:profession.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:profession.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:profession.delete', ['only' => 'destroy']);
        $this->middleware('permission:profession.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de profesiones
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => Profession::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de profesiones
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra una nueva profesión
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:profession,name',
            'acronym' => 'max:10'
        ]);


        $profession = Profession::create([
            'name' => $request->input('name'),
            'acronym' => ($request->input('acronym'))?$request->input('acronym'):null
        ]);

        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca de la profesión
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function show(Profession $profession)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de una profesión
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function edit(Profession $profession)
    {
        //
    }

    /**
     * Actualiza la información de la profesión
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profession $profession)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:profession,name,' . $profession->id,
            'acronym' => 'max:10'
        ]);
 
        $profession->name = $request->input('name');
        $profession->acronym = ($request->input('acronym'))?$request->input('acronym'):null;
        $profession->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina la profesión
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profession $profession)
    {
        $profession->delete();
        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }
}
