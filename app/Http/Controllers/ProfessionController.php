<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

/**
 * @class ProfessionController
 * @brief Gestiona información de Profesiones
 *
 * Controlador para gestionar Profesiones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ProfessionController extends Controller
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
        $this->middleware('permission:profession.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:profession.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:profession.delete', ['only' => 'destroy']);
        $this->middleware('permission:profession.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los registros de profesiones
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse     JSON con el listado de profesiones
     */
    public function index()
    {
        return response()->json(['records' => Profession::all()], 200);
    }

    /**
     * Registra una nueva profesión
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request    Objeto con información de la petición
     *
     * @return JsonResponse         JSON con información del resultado del registro
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'acronym' => ['max:10']
        ]);

        if (!restore_record(Profession::class, ['name' => $request->name])) {
            $this->validate($request, [
                'name' => ['unique:professions,name']
            ]);
        }

        /** @var Profession Objeto con información de la profesión registrada */
        $profession = Profession::updateOrCreate([
            'name' => $request->name
        ], [
            'acronym' => ($request->acronym)?$request->acronym:null
        ]);

        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de una profesión
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request        Objeto con información de la petición
     * @param  Profession  $profession  Objeto con información de la profesión a actualizar
     * @return JsonResponse             JSON con el resultado de la actualización
     */
    public function update(Request $request, Profession $profession)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:professions,name,' . $profession->id],
            'acronym' => ['max:10']
        ]);

        $profession->name = $request->name;
        $profession->acronym = ($request->acronym)?$request->acronym:null;
        $profession->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina una profesión
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Profession  $profession  Objeto con información de la profesión a eliminar
     * @return JsonResponse             JSON con el resultado de la eliminación
     */
    public function destroy(Profession $profession)
    {
        $profession->delete();
        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las profesiones registradas
     *
     * @method  getProfessions
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     *
     * @param  integer $id                      Identificador de la profesión a buscar, este parámetro es opcional
     *
     * @return JsonResponse    JSON con los datos de las profesiones
     */
    public function getProfessions($id = null)
    {
        return response()->json(template_choices('App\Models\Profession', 'name', [], true));
    }
}
