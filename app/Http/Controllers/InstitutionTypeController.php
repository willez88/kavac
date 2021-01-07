<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\InstitutionType;
use Illuminate\Http\Request;

/**
 * @class InstitutionTypeController
 * @brief Gestiona información de los tipos de Organizaciones
 *
 * Controlador para gestionar los tipos de Organizaciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class InstitutionTypeController extends Controller
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
        $this->middleware('permission:institution.type.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:institution.type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:institution.type.delete', ['only' => 'destroy']);
        $this->middleware('permission:institution.type.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los registros de los tipos de organización
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse     JSON con el listado de tipos de organizaciones
     */
    public function index()
    {
        return response()->json(['records' => InstitutionType::all()], 200);
    }

    /**
     * Registra un nuevo tipo de organización
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request    Objeto con información de la petición
     *
     * @return JsonResponse     JSON con información de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'acronym' => ['max:4']
        ]);

        if (!restore_record(InstitutionType::class, ['name' => $request->name])) {
            $this->validate($request, [
                'name' => 'unique:institution_types,name'
            ]);
        }

        /** @var InstitutionType Objeto con información del tipo de organización registrada */
        $institutionType = InstitutionType::updateOrCreate([
            'name' => $request->name
        ], [
            'acronym' => ($request->acronym)?$request->acronym:null
        ]);

        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de organización
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request          $request            Objeto con información de la petición
     * @param  InstitutionType  $institutionType    Objeto con información del tipo de organización a actualizar
     *
     * @return JsonResponse     JSON con información de respuesta a la petición
     */
    public function update(Request $request, InstitutionType $institutionType)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'acronym' => ['max:4']
        ]);

        $institutionType->name = $request->name;
        $institutionType->acronym = ($request->acronym)?$request->acronym:null;
        $institutionType->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina el tipo de organización
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  InstitutionType  $institutionType    Objeto con información del tipo de organización a eliminar
     *
     * @return JsonResponse     JSON con información sobre la eliminación del tipo de organización
     */
    public function destroy(InstitutionType $institutionType)
    {
        $institutionType->delete();
        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }
}
