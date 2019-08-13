<?php

namespace App\Http\Controllers;

use App\Models\InstitutionType;
use Illuminate\Http\Request;

/**
 * @class InstitutionTypeController
 * @brief Gestiona información de los tipos de Instituciones
 *
 * Controlador para gestionar los tipos de Instituciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class InstitutionTypeController extends Controller
{
    /**
     * Define la configuración de la clase
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
     * Muesta todos los registros de los tipos de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => InstitutionType::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'acronym' => 'max:4'
        ]);


        $institutionType = InstitutionType::create([
            'name' => $request->name,
            'acronym' => ($request->acronym)?$request->acronym:null
        ]);

        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionType $institutionType)
    {
        //
    }

    /**
     * Actualiza la información del tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, InstitutionType $institutionType)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'acronym' => 'max:4'
        ]);

        $institutionType->name = $request->name;
        $institutionType->acronym = ($request->acronym)?$request->acronym:null;
        $institutionType->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el tipo de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionType  $institutionType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InstitutionType $institutionType)
    {
        $institutionType->delete();
        return response()->json(['record' => $institutionType, 'message' => 'Success'], 200);
    }
}
