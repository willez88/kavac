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
     * Muesta todos los registros de profesiones
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Profession::all()], 200);
    }

    /**
     * Valida y registra una nueva profesión
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'acronym' => ['max:10']
        ]);

        if ($prof = Profession::onlyTrashed()->whereName($request->name)->first()) {
            $prof->restore();
        } else {
            $this->validate($request, [
                'name' => ['unique:professions,name']
            ]);
        }

        $profession = Profession::updateOrCreate([
            'name' => $request->name
        ], [
            'acronym' => ($request->acronym)?$request->acronym:null
        ]);

        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de la profesión
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\JsonResponse
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
     * Elimina la profesión
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Profession $profession)
    {
        $profession->delete();
        return response()->json(['record' => $profession, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las profesiones registradas
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador de la profesión a buscar, este parámetro es opcional
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de las profesiones
     */
    public function getProfessions($id = null)
    {
        return response()->json(template_choices('App\Models\Profession', 'name', [], true));
    }
}
