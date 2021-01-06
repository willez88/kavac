<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\Request;

/**
 * @class MaritalStatusController
 * @brief Gestiona información de Estados Civiles
 *
 * Controlador para gestionar Estados Civiles
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class MaritalStatusController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => MaritalStatus::all()], 200);
    }

    /**
     * Valida y registra un nuevo estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);

        if ($mStatus = MaritalStatus::onlyTrashed()->whereName($request->name)->first()) {
            $mStatus->restore();
        } else {
            $this->validate($request, [
                'name' => 'unique:marital_status,name'
            ]);
        }

        $maritalStatus = MaritalStatus::updateOrCreate(['name' => $request->name]);

        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, MaritalStatus $maritalStatus)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);

        $maritalStatus->name = $request->name;
        $maritalStatus->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina el estado civil
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();
        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los estados civiles registrados
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id                      Identificador del estado civil a buscar, este parámetro es opcional
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de los estados
     */
    public function getMaritalStatus($id = null)
    {
        return response()->json(template_choices('App\Models\MaritalStatus', 'name', [], true));
    }
}
