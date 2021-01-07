<?php
/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\RequiredDocument;
use Illuminate\Http\Request;

/**
 * @class RequiredDocumentController
 * @brief Gestiona información de documentos requeridos
 *
 * Controlador para gestionar documentos requeridos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class RequiredDocumentController extends Controller
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
        $this->middleware('permission:estate.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:estate.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estate.delete', ['only' => 'destroy']);
        $this->middleware('permission:estate.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los requerimientos de documentos registrados
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     string        $model     Nombre del modelo de referencia
     * @param     string|null   $module    Nombre del módulo de referencia. Este parámetro es opcional
     *
     * @return    JsonResponse  JSON con el listado de requerimientos de documentos
     */
    public function index($model, $module = null)
    {
        return response()->json([
            'records' => RequiredDocument::where(['model' => $model, 'module' => $module])->get()
        ], 200);
    }

    /**
     * Registra un nuevo requerimiento de documentos
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request       $request    Objeto con información de la petición
     * @param     string        $model      Nombre del modelo de referencia
     * @param     string|null   $module     Nombre del módulo de referencia. Este parámetro es opcional
     *
     * @return    JsonResponse  JSON con el resultado de requerimientos de documentos registrado
     */
    public function store(Request $request, $model, $module = null)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        /** @var RequiredDocument Objeto con información del requerimiento de documento registrado */
        $requiredDocument = RequiredDocument::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'module' => $module,
            'model' => $model
        ]);

        return response()->json(['record' => $requiredDocument, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de un requerimiento de documento
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request             $request             Objeto con información de la petición
     * @param     string              $model               Nombre del modelo de referencia
     * @param     string|null         $module              Nombre del módulo de referencia
     * @param     RequiredDocument    $requiredDocument    Objeto con información del requerimiento de documento a
     *                                                     actualizar
     *
     * @return    JsonResponse        JSON con el resultado de requerimientos de documentos registrado
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
     * Elimina un requerimiento de documento
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     string              $model               Nombre del modelo de referencia
     * @param     string|null         $module              Nombre del módulo de referencia
     * @param     RequiredDocument    $requiredDocument    Objeto con información del requerimiento de documento a
     *                                                     actualizar
     *
     * @return    JsonResponse        JSON con el resultado de requerimientos de documentos registrado
     */
    public function destroy($model, $module, RequiredDocument $requiredDocument)
    {
        $requiredDocument->delete();
        return response()->json(['record' => $requiredDocument, 'message' => 'Success'], 200);
    }
}
