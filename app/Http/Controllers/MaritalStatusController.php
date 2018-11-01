<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:marital.status.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:marital.status.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:marital.status.delete', ['only' => 'destroy']);
        $this->middleware('permission:marital.status.list', ['only' => 'index']);
    }

    /**
     * Muestra todos los registros de estados civiles
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => MaritalStatus::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de estados civiles
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'marital_status_name' => 'required|max:100'
        ]);

        $maritalStatus = MaritalStatus::create(['name' => $request->input('marital_status_name')]);

        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MaritalStatus $maritalStatus)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(MaritalStatus $maritalStatus)
    {
        //
    }

    /**
     * Actualiza la información del estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, MaritalStatus $maritalStatus)
    {
        $this->validate($request, [
            'marital_status_name' => 'required|max:100'
        ]);
 
        $maritalStatus->name = $request->input('marital_status_name');
        $maritalStatus->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();
        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }
}
