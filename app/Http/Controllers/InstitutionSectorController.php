<?php

namespace App\Http\Controllers;

use App\Models\InstitutionSector;
use Illuminate\Http\Request;

class InstitutionSectorController extends Controller
{
    /**
     * Muesta todos los registros de los sectores de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['records' => InstitutionSector::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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

        return response()->json(['record' => $institutionSector, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Actualiza la información del sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
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
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionSector $institutionSector)
    {
        $institutionSector->delete();
        return response()->json(['record' => $institutionSector, 'message' => 'Success'], 200);
    }
}
