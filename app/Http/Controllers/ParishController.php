<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Parish;
use Illuminate\Http\Request;
use App\Rules\UniqueParishCode;

/**
 * @class ParishController
 * @brief Gestiona información de Parroquias
 *
 * Controlador para gestionar Parroquias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ParishController extends Controller
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
        $this->middleware('permission:parish.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:parish.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:parish.delete', ['only' => 'destroy']);
        $this->middleware('permission:parish.list', ['only' => 'index']);
    }

    /**
     * Listado de todas las parroquias registradas
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse    JSON con el listado de parroquias
     */
    public function index(Request $request)
    {
        $data = Parish::with('municipality');

        if (!empty($request->query('query')) && $request->query('query')!=="{}") {
            $data = $data->search($request->query('query'));
        }
        if ($request->orderBy) {
            $data = $data->orderByColumn($request->orderBy, $request->ascending);
        }

        $data = $data->paginate($request->limit);

        return response()->json([
            'data' => $data->items(),
            'count' => $data->total()
        ], 200, [], env('APP_DEBUG') == true ? JSON_PRETTY_PRINT : 0);
    }

    /**
     * Registra una nueva parroquia
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse     JSON con datos sobre el registro de la parroquia
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10', new UniqueParishCode],
            'municipality_id' => ['required']
        ]);

        /** @var Parish Objeto con información de la parroquia registrada */
        $parish = Parish::create([
            'name' => $request->name,
            'code' => $request->code,
            'municipality_id' => $request->municipality_id
        ]);

        return response()->json(['record' => $parish, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza los datos de una parroquia
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     * @param     Parish     $parish     Objeto con información de la parroquia a actualizar
     *
     * @return    JsonResponse          JSON con datos sobre la actualización de la parroquia
     */
    public function update(Request $request, Parish $parish)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'municipality_id' => ['required']
        ]);

        $parish->name = $request->name;
        $parish->code = $request->code;
        $parish->municipality_id = $request->municipality_id;
        $parish->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina una parroquia
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Parish     $parish    Objeto con información de la parroquia a eliminar
     *
     * @return    JsonResponse          JSON con datos sobre la eliminación de la parroquia
     */
    public function destroy(Parish $parish)
    {
        $parish->delete();
        return response()->json(['record' => $parish, 'message' => 'Success'], 200);
    }
}
