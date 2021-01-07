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
     * @method  __construct
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
     * Listado de todos los registros de estados civiles
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse     JSON con información de los estados civiles registrados
     */
    public function index()
    {
        return response()->json(['records' => MaritalStatus::all()], 200);
    }

    /**
     * Registra un nuevo estado civil
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request    Objeto con información de la petición
     *
     * @return JsonResponse         JSON con los datos de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100']
        ]);

        if (!restore_record(MaritalStatus::class, ['name' => $request->name])) {
            $this->validate($request, [
                'name' => 'unique:marital_status,name'
            ]);
        }

        /** @var MaritalStatus Objeto con información del estado civil registrado */
        $maritalStatus = MaritalStatus::updateOrCreate(['name' => $request->name]);

        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de un estado civil
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request        $request          Objeto con información de la petición
     * @param  MaritalStatus  $MaritalStatus    Objeto con información del estado civil a actualizar
     * @return JsonResponse
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
     * Elimina un estado civil
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  MaritalStatus  $maritalStatus    Objeto con información del estado civil a eliminar
     *
     * @return JsonResponse     JSON con información del proceso de eliminación del estado civil
     */
    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();
        return response()->json(['record' => $maritalStatus, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los estados civiles registrados
     *
     * @method  getMaritalStatus
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  integer $id                      Identificador del estado civil a buscar, este parámetro es opcional
     *
     * @return JsonResponse    JSON con los datos de los estados
     */
    public function getMaritalStatus($id = null)
    {
        /** @var array Arreglo con el filtro a través del ID del registro en caso de ser indicado */
        $filterId = (!is_null($id)) ? ['id' => $id] : [];
        return response()->json(template_choices('App\Models\MaritalStatus', 'name', $filterId, true));
    }
}
